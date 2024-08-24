<?php
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';
$id = $_GET['id'] ?? null;

switch ($endpoint) {
    case 'categorias':
        handleCategorias($method, $id, $pdo);
        break;
    case 'items':
        handleItems($method, $id, $pdo);
        break;
    case 'usuarios':
        handleUsuarios($method, $id, $pdo);
        break;
    default:
        echo json_encode(['error' => 'Endpoint no válido']);
}

function handleCategorias($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
                $stmt->execute([$id]);
                $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($categoria);
            } else {
                $stmt = $pdo->query("SELECT * FROM categorias");
                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($categorias);
            }
            break;
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO categorias (nombre) VALUES (?)");
            $stmt->execute([$input['nombre']]);
            echo json_encode(['message' => 'Categoría creada', 'id' => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            if ($id) {
                $input = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
                $stmt->execute([$input['nombre'], $id]);
                echo json_encode(['message' => 'Categoría actualizada']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['message' => 'Categoría eliminada']);
            }
            break;
    }
}

function handleItems($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
                $stmt->execute([$id]);
                $item = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($item);
            } else {
                $stmt = $pdo->query("SELECT * FROM items");
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($items);
            }
            break;
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO items (nombre, descripcion, categoria_id) VALUES (?, ?, ?)");
            $stmt->execute([$input['nombre'], $input['descripcion'], $input['categoria_id']]);
            echo json_encode(['message' => 'Item creado', 'id' => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            if ($id) {
                $input = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE items SET nombre = ?, descripcion = ?, categoria_id = ? WHERE id = ?");
                $stmt->execute([$input['nombre'], $input['descripcion'], $input['categoria_id'], $id]);
                echo json_encode(['message' => 'Item actualizado']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['message' => 'Item eliminado']);
            }
            break;
    }
}

function handleUsuarios($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
                $stmt->execute([$id]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($usuario);
            } else {
                $stmt = $pdo->query("SELECT * FROM usuarios");
                $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($usuarios);
            }
            break;
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, email) VALUES (?, ?)");
            $stmt->execute([$input['nombre_usuario'], $input['email']]);
            echo json_encode(['message' => 'Usuario creado', 'id' => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            if ($id) {
                $input = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE usuarios SET nombre_usuario = ?, email = ? WHERE id = ?");
                $stmt->execute([$input['nombre_usuario'], $input['email'], $id]);
                echo json_encode(['message' => 'Usuario actualizado']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['message' => 'Usuario eliminado']);
            }
            break;
    }
}
?>