<?php
header('Content-Type: application/json');

class SpeedTestServer {
    public function GetServerUptime() {
        $uptime = null;
        if (stristr(PHP_OS, 'WIN')) {
            // Windows: Use WMIC to get uptime in seconds
            $output = shell_exec('wmic os get LastBootUpTime /value');
            if ($output) {
                preg_match('/LastBootUpTime=(\d{14})/', $output, $matches);
                if (isset($matches[1])) {
                    $bootTime = DateTime::createFromFormat('YmdHis', substr($matches[1], 0, 14));
                    $now = new DateTime();
                    $uptimeseconds = $now->getTimestamp() - $bootTime->getTimestamp();
                    $uptime = gmdate("H:i:s", $uptimeseconds);}
            }
        } else {
            // Linux/Unix: Use uptime command
            $input = shell_exec('uptime');

            // Pattern looks for "up " followed by digits:digits
            $pattern = '/up\s+(.*?),\s+load/';
            if (preg_match($pattern, $input, $matches)) {
                // $matches[0] is the full match "up 19:53"
                // $matches[1] is the first capture group "19:53"
                $uptime = $matches[1];
            } else {
                $uptime = "Uptime not found.";
            }
        }
        return [
            'uptime' => $uptime
        ];
    }
}

$server = new SpeedTestServer();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['method']) && $_GET['method'] === 'GetServerUptime') {
    echo json_encode($server->GetServerUptime());
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Method not found']);
}