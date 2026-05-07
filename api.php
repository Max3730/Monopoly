<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Fichier de stockage des parties
$gamesFile = 'games.json';

// Charger les parties existantes
function loadGames() {
    global $gamesFile;
    if (!file_exists($gamesFile)) {
        return [];
    }
    $data = file_get_contents($gamesFile);
    return json_decode($data, true) ?: [];
}

// Sauvegarder les parties
function saveGames($games) {
    global $gamesFile;
    file_put_contents($gamesFile, json_encode($games, JSON_PRETTY_PRINT));
}

// Nettoyer les anciennes parties (plus de 24h)
function cleanupOldGames() {
    $games = loadGames();
    $now = time();
    $cleaned = false;
    
    foreach ($games as $code => $game) {
        if ($now - ($game['createdAt'] / 1000) > 86400) { // 24 heures
            unset($games[$code]);
            $cleaned = true;
        }
    }
    
    if ($cleaned) {
        saveGames($games);
    }
}

// Nettoyer automatiquement
cleanupOldGames();

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Récupérer les données POST
$input = json_decode(file_get_contents('php://input'), true);

// Routeur basé sur l'action
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $playerName = $input['playerName'] ?? '';
        if (empty($playerName)) {
            http_response_code(400);
            echo json_encode(['error' => 'Player name required']);
            exit;
        }
        
        // Générer un code unique
        do {
            $code = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            for ($i = 0; $i < 6; $i++) {
                $code .= $chars[rand(0, strlen($chars) - 1)];
            }
        } while (isset(loadGames()[$code]));
        
        // Créer la partie
        $games = loadGames();
        $games[$code] = [
            'players' => [$playerName],
            'currentPlayerIndex' => 0,
            'positions' => [0, 0],
            'gameStarted' => false,
            'createdAt' => time() * 1000
        ];
        saveGames($games);
        
        echo json_encode(['code' => $code, 'game' => $games[$code]]);
        break;
        
    case 'join':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $playerName = $input['playerName'] ?? '';
        $code = strtoupper($input['code'] ?? '');
        
        if (empty($playerName) || empty($code)) {
            http_response_code(400);
            echo json_encode(['error' => 'Player name and code required']);
            exit;
        }
        
        $games = loadGames();
        
        if (!isset($games[$code])) {
            http_response_code(404);
            echo json_encode(['error' => 'Invalid invitation code']);
            exit;
        }
        
        if (count($games[$code]['players']) >= 2) {
            http_response_code(400);
            echo json_encode(['error' => 'Game already full']);
            exit;
        }
        
        // Ajouter le joueur
        $games[$code]['players'][] = $playerName;
        saveGames($games);
        
        echo json_encode(['code' => $code, 'game' => $games[$code]]);
        break;
        
    case 'get':
        if ($method !== 'GET') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $code = strtoupper($_GET['code'] ?? '');
        
        if (empty($code)) {
            http_response_code(400);
            echo json_encode(['error' => 'Code required']);
            exit;
        }
        
        $games = loadGames();
        
        if (!isset($games[$code])) {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
            exit;
        }
        
        echo json_encode(['code' => $code, 'game' => $games[$code]]);
        break;
        
    case 'update':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $code = strtoupper($input['code'] ?? '');
        $gameState = $input['gameState'] ?? [];
        
        if (empty($code) || empty($gameState)) {
            http_response_code(400);
            echo json_encode(['error' => 'Code and gameState required']);
            exit;
        }
        
        $games = loadGames();
        
        if (!isset($games[$code])) {
            http_response_code(404);
            echo json_encode(['error' => 'Game not found']);
            exit;
        }
        
        $games[$code] = $gameState;
        saveGames($games);
        
        echo json_encode(['success' => true]);
        break;
        
    case 'delete':
        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }
        
        $code = strtoupper($input['code'] ?? '');
        
        if (empty($code)) {
            http_response_code(400);
            echo json_encode(['error' => 'Code required']);
            exit;
        }
        
        $games = loadGames();
        
        if (isset($games[$code])) {
            unset($games[$code]);
            saveGames($games);
        }
        
        echo json_encode(['success' => true]);
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
