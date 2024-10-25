<?php
session_start();
include("../../../../backend/conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $emailFornecedor = $_POST['emailFornecedor'];
    $produtoFornecedor = $_POST['produtoFornecedor'];
    $telefoneFornecedor = $_POST['telefoneFornecedor'];
    $enderecoFornecedor = $_POST['enderecoFornecedor'];

    $stmtEndereco = $conexao->prepare("INSERT INTO endereco (rua) VALUES (?)");
    $stmtEndereco->bind_param("s", $enderecoFornecedor); 
    if ($stmtEndereco->execute()) {
        $idEndereco = $stmtEndereco->insert_id;

        // Insert supplier data
        $stmtFornecedor = $conexao->prepare("INSERT INTO fornecedor (nomeFornecedor, emailFornecedor, produtoFornecedor, telefoneFornecedor, fkIdEndereco) VALUES (?, ?, ?, ?, ?)");
        $stmtFornecedor->bind_param("ssssi", $nomeFornecedor, $emailFornecedor, $produtoFornecedor, $telefoneFornecedor, $idEndereco);

        if ($stmtFornecedor->execute()) {
            header("Location: listar_fornecedores.php");
            exit();
        } else {
            echo "Erro ao cadastrar fornecedor: " . $stmtFornecedor->error;
        }
    } else {
        echo "Erro ao cadastrar endereço: " . $stmtEndereco->error;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Fornecedor</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <div class="relative w-full max-w-5xl p-6 mx-auto">
        <div class="p-6">
            <h1 class="mb-4 text-2xl font-bold">Cadastrar Fornecedor</h1>
            <form method="POST">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nome do Fornecedor:</label>
                        <input type="text" name="nomeFornecedor" required
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email:</label>
                        <input type="email" name="emailFornecedor" required
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Endereço:</label>
                        <input type="text" name="enderecoFornecedor"
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Produto:</label>
                        <input type="text" name="produtoFornecedor"
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Telefone:</label>
                        <input type="text" name="telefoneFornecedor"
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md" />
                    </div>
                </div>

                <button type="submit"
                    class="text-white inline-flex items-center bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Cadastrar Fornecedor
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"> </script>
</body>

</html>