<?php
// in Laravel project root create also wsserver.php
// use 'php wsserver' to launch Web Socket server
// Make sure composer dependencies have been installed
require __DIR__ . '/vendor/autoload.php';
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class WebSocketLaravelServer implements MessageComponentInterface
{
    protected $clients;
    public function __construct() {
        echo 'Creating app...' . PHP_EOL;
        $this->clients = new \SplObjectStorage;
    }
    protected function handleLaravelRequest(ConnectionInterface $con, $route, $data = null)
    {
        /**
         * @var \Ratchet\WebSocket\Version\RFC6455\Connection $con
         * @var \Guzzle\Http\Message\Request $wsrequest
         * @var \Illuminate\Http\Response $response
         */
        $params = [
            'connection' => $con,
            'other_clients' => [],
        ];
        if ($data !== null) {
            if (is_string($data)) {
                $params = ['data' => json_decode($data)];
            } else {
                $params = ['data' => $data];
            }
        }
        foreach ($this->clients as $client) {
            if ($con != $client) {
                $params['other_clients'][] = $client;
            } else {
                $params['current_client'] = $client;
            }
        }
        $wsrequest = $con->WebSocket->request;
        $app = require __DIR__.'/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        $response = $kernel->handle(
            $request = Illuminate\Http\Request::create($route, 'GET', $params, $wsrequest->getCookies())
        );
        //var_dump(Auth::id());
        $controllerResult = $response->getContent();
        $kernel->terminate($request, $response);
        return json_encode($controllerResult);
    }
    public function onOpen(ConnectionInterface $con)
    {
        $this->clients->attach($con);
        $this->handleLaravelRequest($con, '/websocket/open');
    }
    public function onMessage(ConnectionInterface $con, $msg)
    {
        $this->handleLaravelRequest($con, '/websocket/message', $msg);
    }
    public function onClose(ConnectionInterface $con)
    {
        $this->handleLaravelRequest($con, '/websocket/close');
        $this->clients->detach($con);
    }
    public function onError(ConnectionInterface $con, \Exception $e)
    {
        $this->handleLaravelRequest($con, '/websocket/error');
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
        $con->close();
    }
}
// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('192.168.1.100', 8080);
$app->route('/echo', new WebSocketLaravelServer);
$app->run();