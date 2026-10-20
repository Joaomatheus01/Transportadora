<?php
// CONFIGURAÇÕES INICIAIS
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require "config.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];
$corpo = json_decode(file_get_contents("php://input"), true) ?? [];

function teste() {
    echo json_encode(["mensagem" => "Back-end da transportadora respondendo!"]);
    exit;
}

// CRUD - CLIENTE
function createCliente($con, $dados) {
    $stmt = $con->prepare("INSERT INTO CLIENTE (NOME, ENDERECO, TELEFONE, EMAIL) VALUES (?, ?, ?, ?)");
    $stmt->execute([$dados["nome"] ?? null, $dados["endereco"] ?? null, $dados["telefone"] ?? null, $dados["email"] ?? null]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Cliente criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readCliente($con) {
    $stmt = $con->query("SELECT * FROM CLIENTE");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateCliente($con, $id, $dados) {
    $stmt = $con->prepare("UPDATE CLIENTE SET NOME = ?, ENDERECO = ?, TELEFONE = ?, EMAIL = ? WHERE idCliente = ?");
    $stmt->execute([$dados["nome"] ?? null, $dados["endereco"] ?? null, $dados["telefone"] ?? null, $dados["email"] ?? null, $id]);
    echo json_encode(["mensagem" => "Cliente atualizado com sucesso!"]);
}

function deleteCliente($con, $id) {
    $stmt = $con->prepare("DELETE FROM CLIENTE WHERE idCliente = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Cliente removido com sucesso!"]);
}

// CRUD - FUNCIONARIO
function createFuncionario($con, $dados) {
    $stmt = $con->prepare("INSERT INTO FUNCIONARIO (nome, cargo, salario) VALUES (?, ?, ?)");
    $stmt->execute([$dados["nome"] ?? null, $dados["cargo"] ?? null, $dados["salario"] ?? null]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Funcionário criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readFuncionario($con) {
    $stmt = $con->query("SELECT * FROM FUNCIONARIO");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateFuncionario($con, $id, $dados) {
    $stmt = $con->prepare("UPDATE FUNCIONARIO SET nome = ?, cargo = ?, salario = ? WHERE idFuncionario = ?");
    $stmt->execute([$dados["nome"] ?? null, $dados["cargo"] ?? null, $dados["salario"] ?? null, $id]);
    echo json_encode(["mensagem" => "Funcionário atualizado com sucesso!"]);
}

function deleteFuncionario($con, $id) {
    $stmt = $con->prepare("DELETE FROM FUNCIONARIO WHERE idFuncionario = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Funcionário removido com sucesso!"]);
}

// CRUD - VEICULO
function createVeiculo($con, $dados) {
    $stmt = $con->prepare("INSERT INTO VEICULO (placa, capacidade, modelo) VALUES (?, ?, ?)");
    $stmt->execute([$dados["placa"] ?? null, $dados["capacidade"] ?? null, $dados["modelo"] ?? null]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Veículo criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readVeiculo($con) {
    $stmt = $con->query("SELECT * FROM VEICULO");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateVeiculo($con, $id, $dados) {
    $stmt = $con->prepare("UPDATE VEICULO SET placa = ?, capacidade = ?, modelo = ? WHERE idVeiculo = ?");
    $stmt->execute([$dados["placa"] ?? null, $dados["capacidade"] ?? null, $dados["modelo"] ?? null, $id]);
    echo json_encode(["mensagem" => "Veículo atualizado com sucesso!"]);
}

function deleteVeiculo($con, $id) {
    $stmt = $con->prepare("DELETE FROM VEICULO WHERE idVeiculo = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Veículo removido com sucesso!"]);
}

// ROTAS
if ($rota == "cliente") {
    switch ($metodo) {
        case "GET": readCliente($con); break;
        case "POST": createCliente($con, $corpo); break;
        case "PUT": updateCliente($con, $_GET["id"] ?? null, $corpo); break;
        case "DELETE": deleteCliente($con, $_GET["id"] ?? null); break;
        default: teste(); break;
    }
} elseif ($rota == "funcionario") {
    switch ($metodo) {
        case "GET": readFuncionario($con); break;
        case "POST": createFuncionario($con, $corpo); break;
        case "PUT": updateFuncionario($con, $_GET["id"] ?? null, $corpo); break;
        case "DELETE": deleteFuncionario($con, $_GET["id"] ?? null); break;
        default: teste(); break;
    }
} elseif ($rota == "veiculo") {
    switch ($metodo) {
        case "GET": readVeiculo($con); break;
        case "POST": createVeiculo($con, $corpo); break;
        case "PUT": updateVeiculo($con, $_GET["id"] ?? null, $corpo); break;
        case "DELETE": deleteVeiculo($con, $_GET["id"] ?? null); break;
        default: teste(); break;
    }
} else {
    teste();
}