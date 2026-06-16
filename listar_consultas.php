<?php
include 'conexao.php';

// Processar ações via GET (links)
if(isset($_GET['acao']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $acao = $_GET['acao'];
    $redirect_msg = '';
    
    if($acao == 'cancelar') {
        $sql = "UPDATE consultas SET status = 'cancelado' WHERE id = '$id'";
        if(mysqli_query($conn, $sql)) {
            $redirect_msg = 'cancelado';
        } else {
            $redirect_msg = 'erro';
        }
    } 
    elseif($acao == 'confirmar') {
        $sql = "UPDATE consultas SET status = 'agendado' WHERE id = '$id'";
        if(mysqli_query($conn, $sql)) {
            $redirect_msg = 'confirmado';
        } else {
            $redirect_msg = 'erro';
        }
    }
    elseif($acao == 'concluir') {
        $sql = "UPDATE consultas SET status = 'concluido' WHERE id = '$id'";
        if(mysqli_query($conn, $sql)) {
            $redirect_msg = 'concluido';
        } else {
            $redirect_msg = 'erro';
        }
    }
    
    if($redirect_msg) {
        header('Location: listar_consultas.php?msg=' . $redirect_msg);
        exit();
    }
}

// Processar edição via POST
if(isset($_POST['editar_consulta'])) {
    $id = mysqli_real_escape_string($conn, $_POST['consulta_id']);
    $data = mysqli_real_escape_string($conn, $_POST['data']);
    $horario = mysqli_real_escape_string($conn, $_POST['horario']);
    $procedimento = mysqli_real_escape_string($conn, $_POST['procedimento']);
    
    $sql_edit = "UPDATE consultas SET data_consulta = '$data', horario = '$horario', procedimento = '$procedimento' WHERE id = '$id'";
    if(mysqli_query($conn, $sql_edit)) {
        header('Location: listar_consultas.php?msg=editado');
        exit();
    } else {
        header('Location: listar_consultas.php?msg=erro');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Consultas - Clínica Odontológica</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        /* Container principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Navbar */
        .navbar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            position: relative;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 2;
        }

        .logo span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 8px 15px;
            border-radius: 10px;
            color: white;
        }

        /* Menu Hambúrguer */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            z-index: 2;
        }

        .menu-toggle span {
            width: 30px;
            height: 3px;
            background: #667eea;
            margin: 3px 0;
            transition: 0.3s;
            border-radius: 3px;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            list-style: none;
            transition: all 0.3s ease;
        }

        .nav-links a {
            color: #333;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-block;
        }

        .nav-links a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Cards de consultas */
        .consultas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: center;
        }

        .card-header h3 {
            font-size: 1.2rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: bold;
            color: #667eea;
        }

        .info-value {
            color: #333;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .status-agendado {
            background: #4CAF50;
            color: white;
        }

        .status-cancelado {
            background: #f44336;
            color: white;
        }

        .status-concluido {
            background: #2196F3;
            color: white;
        }

        /* Botões de ação */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-edit, .btn-cancel, .btn-confirmar, .btn-concluir {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-edit {
            background: #2196F3;
            color: white;
        }

        .btn-edit:hover {
            background: #0b7dda;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #f44336;
            color: white;
        }

        .btn-cancel:hover {
            background: #da190b;
            transform: translateY(-2px);
        }

        .btn-confirmar {
            background: #4CAF50;
            color: white;
        }

        .btn-confirmar:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-concluir {
            background: #ff9800;
            color: white;
        }

        .btn-concluir:hover {
            background: #e68900;
            transform: translateY(-2px);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 20px;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .modal-buttons button, .modal-buttons a {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-group input,
        .input-group textarea,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .input-group input:focus,
        .input-group textarea:focus,
        .input-group select:focus {
            border-color: #667eea;
            outline: none;
        }

        /* Mensagem quando não há consultas */
        .no-results {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            color: #667eea;
            font-size: 1.2rem;
        }

        /* Título */
        .page-title {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        /* Botão de voltar */
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #667eea;
            color: white;
            transform: translateX(-5px);
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 12px;
            font-weight: 500;
            animation: slideInRight 0.3s ease;
            z-index: 1001;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 250px;
            max-width: 400px;
        }

        .toast-success {
            background: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #38a169;
        }

        .toast-error {
            background: #fed7d7;
            color: #742a2a;
            border-left: 4px solid #e53e3e;
        }

        .toast-info {
            background: #bee3f8;
            color: #2c5282;
            border-left: 4px solid #3182ce;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-hide {
            animation: slideOutRight 0.3s ease forwards;
        }

        /* Overlay para mobile */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .overlay.active {
            display: block;
        }

        /* Responsividade com Menu Hambúrguer */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                max-width: 300px;
                height: 100vh;
                background: white;
                flex-direction: column;
                justify-content: flex-start;
                padding: 80px 20px 20px;
                gap: 20px;
                z-index: 999;
                transition: 0.3s;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links a {
                display: block;
                padding: 12px 20px;
                text-align: center;
                font-size: 1.1rem;
            }

            .consultas-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }

            body {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .nav-links {
                width: 85%;
            }

            .card {
                padding: 15px;
            }

            .info-row {
                font-size: 0.9rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

        <!-- Navbar -->
        <nav class="navbar">
            <div class="nav-container">
                <a href="index.html" class="logo">
                    🦷 <span>OdontoAgenda</span>
                </a>
                <div class="menu-toggle" id="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="cadastrar_paciente.php">📋 Cadastrar Paciente</a></li>
                    <li><a href="cadastrar_dentista.php">👨‍⚕️ Cadastrar Dentista</a></li>
                    <li><a href="agendar_consulta.php">📅 Agendar Consulta</a></li>
                    <li><a href="listar_consultas.php">📊 Listar Consultas</a></li>
                </ul>
            </div>
        </nav>

        <!-- Título -->
        <h1 class="page-title">📋 Lista de Consultas Agendadas</h1>

        <?php
        // Verificar se há mensagem na URL
        $mensagem = '';
        $tipo_mensagem = '';

        if(isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            if($msg == 'cancelado') {
                $mensagem = 'Consulta cancelada com sucesso!';
                $tipo_mensagem = 'success';
            } elseif($msg == 'confirmado') {
                $mensagem = 'Consulta confirmada com sucesso!';
                $tipo_mensagem = 'success';
            } elseif($msg == 'concluido') {
                $mensagem = 'Consulta concluída com sucesso!';
                $tipo_mensagem = 'success';
            } elseif($msg == 'editado') {
                $mensagem = 'Consulta editada com sucesso!';
                $tipo_mensagem = 'success';
            } elseif($msg == 'erro') {
                $mensagem = 'Erro ao realizar operação!';
                $tipo_mensagem = 'error';
            }
        }
        
        // Buscar nomes dos pacientes e dentistas
        $sql = "SELECT c.*, p.nome as paciente_nome, d.nome as dentista_nome 
                FROM consultas c
                LEFT JOIN pacientes p ON c.paciente_id = p.id
                LEFT JOIN dentistas d ON c.dentista_id = d.id
                ORDER BY c.data_consulta DESC, c.horario ASC";
        $resultado = mysqli_query($conn, $sql);
        ?>
        
        <!-- Toast Container -->
        <div id="toastContainer"></div>

        <?php
        if(mysqli_num_rows($resultado) > 0) {
            echo '<div class="consultas-grid">';
            while($dados = mysqli_fetch_assoc($resultado)) {
                // Definir classe de status
                $statusClass = '';
                $statusText = '';
                switch($dados['status']) {
                    case 'agendado':
                        $statusClass = 'status-agendado';
                        $statusText = 'Confirmado';
                        break;
                    case 'cancelado':
                        $statusClass = 'status-cancelado';
                        $statusText = 'Cancelado';
                        break;
                    case 'concluido':
                        $statusClass = 'status-concluido';
                        $statusText = 'Concluído';
                        break;
                    default:
                        $statusClass = 'status-agendado';
                        $statusText = 'Confirmado';
                }
                
                echo '<div class="card">';
                echo '<div class="card-header">';
                echo '<h3>Consulta #' . $dados['id'] . '</h3>';
                echo '</div>';
                echo '<div class="info-row">';
                echo '<span class="info-label">Paciente:</span>';
                echo '<span class="info-value">' . htmlspecialchars($dados['paciente_nome']) . '</span>';
                echo '</div>';
                echo '<div class="info-row">';
                echo '<span class="info-label">Dentista:</span>';
                echo '<span class="info-value">' . htmlspecialchars($dados['dentista_nome']) . '</span>';
                echo '</div>';
                echo '<div class="info-row">';
                echo '<span class="info-label">Data:</span>';
                echo '<span class="info-value">' . date('d/m/Y', strtotime($dados['data_consulta'])) . '</span>';
                echo '</div>';
                echo '<div class="info-row">';
                echo '<span class="info-label">Horário:</span>';
                echo '<span class="info-value">' . $dados['horario'] . '</span>';
                echo '</div>';
                echo '<div class="info-row">';
                echo '<span class="info-label">Procedimento:</span>';
                echo '<span class="info-value">' . htmlspecialchars($dados['procedimento']) . '</span>';
                echo '</div>';
                echo '<div class="info-row">';
                echo '<span class="info-label">Status:</span>';
                echo '<span class="info-value"><span class="status ' . $statusClass . '">' . $statusText . '</span></span>';
                echo '</div>';
                
                // Botões de ação baseados no status
                echo '<div class="action-buttons">';
                
                // Botão Editar (sempre disponível para consultas não canceladas)
                if($dados['status'] != 'cancelado') {
                    echo '<button class="btn-edit" onclick="openEditModal(' . $dados['id'] . ', \'' . $dados['data_consulta'] . '\', \'' . $dados['horario'] . '\', \'' . addslashes($dados['procedimento']) . '\')">✏️ Editar</button>';
                }
                
                // Botões baseados no status atual
                if($dados['status'] == 'agendado') {
                    echo '<button class="btn-concluir" onclick="openConfirmModal(' . $dados['id'] . ', \'concluir\')">✅ Concluir</button>';
                    echo '<button class="btn-cancel" onclick="openConfirmModal(' . $dados['id'] . ', \'cancelar\')">❌ Cancelar</button>';
                } 
                elseif($dados['status'] == 'cancelado') {
                    echo '<button class="btn-confirmar" onclick="openConfirmModal(' . $dados['id'] . ', \'confirmar\')">↩️ Reativar Consulta</button>';
                }
                elseif($dados['status'] == 'concluido') {
                    // Não mostrar botões para consultas concluídas
                }
                
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="no-results">';
            echo '📭 Nenhuma consulta encontrada.';
            echo '<br><br>';
            echo '<a href="agendar_consulta.php" class="back-button">➕ Agendar Primeira Consulta</a>';
            echo '</div>';
        }
        ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="agendar_consulta.php" class="back-button">← Voltar para Agendamento</a>
        </div>
    </div>

    <!-- Modal de Confirmação (Cancelar/Confirmar/Concluir) -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <h3 id="confirmTitle">Confirmar Ação</h3>
            <p id="confirmMessage">Tem certeza que deseja realizar esta ação?</p>
            <div class="modal-buttons">
                <a href="#" id="confirmLink" style="padding: 10px 20px; text-decoration: none; border-radius: 8px;">Sim</a>
                <button type="button" class="btn-close" onclick="closeConfirmModal()">Não</button>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div id="editModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <h3>✏️ Editar Consulta</h3>
            <form method="POST" id="editForm">
                <input type="hidden" name="consulta_id" id="editId">
                <div class="input-group">
                    <label>📅 Data da Consulta</label>
                    <input type="date" name="data" id="editData" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="input-group">
                    <label>⏰ Horário</label>
                    <input type="time" name="horario" id="editHorario" required>
                </div>
                <div class="input-group">
                    <label>🦷 Procedimento</label>
                    <textarea name="procedimento" id="editProcedimento" required rows="3"></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="submit" name="editar_consulta" style="background: #2196F3; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">Salvar Alterações</button>
                    <button type="button" class="btn-close" onclick="closeEditModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Menu Hambúrguer
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');
        const overlay = document.getElementById('overlay');

        function toggleMenu() {
            menuToggle.classList.toggle('active');
            navLinks.classList.toggle('active');
            overlay.classList.toggle('active');
            
            if (navLinks.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function closeMenu() {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuToggle.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', closeMenu);

        const links = document.querySelectorAll('.nav-links a');
        links.forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMenu();
            }
        });

        // Toast Notification System
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            const icon = type === 'success' ? '✅' : (type === 'error' ? '❌' : 'ℹ️');
            toast.innerHTML = `${icon} ${message}`;
            
            toastContainer.appendChild(toast);
            
            // Remover após 3 segundos
            setTimeout(() => {
                toast.classList.add('toast-hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        // Verificar mensagem da URL e mostrar toast
        <?php if($mensagem && $tipo_mensagem): ?>
        showToast('<?php echo addslashes($mensagem); ?>', '<?php echo $tipo_mensagem; ?>');
        // Limpar URL após mostrar mensagem
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
        <?php endif; ?>

        // Modal de Confirmação
        const confirmModal = document.getElementById('confirmModal');
        const confirmTitle = document.getElementById('confirmTitle');
        const confirmMessage = document.getElementById('confirmMessage');
        const confirmLink = document.getElementById('confirmLink');
        
        function openConfirmModal(id, acao) {
            let title = '';
            let message = '';
            let link = '';
            let buttonColor = '';
            
            if(acao == 'cancelar') {
                title = '❌ Cancelar Consulta';
                message = 'Tem certeza que deseja cancelar esta consulta?';
                link = 'listar_consultas.php?acao=cancelar&id=' + id;
                buttonColor = '#f44336';
            } else if(acao == 'confirmar') {
                title = '✅ Confirmar Consulta';
                message = 'Tem certeza que deseja confirmar esta consulta?';
                link = 'listar_consultas.php?acao=confirmar&id=' + id;
                buttonColor = '#4CAF50';
            } else if(acao == 'concluir') {
                title = '🏁 Concluir Consulta';
                message = 'Tem certeza que deseja marcar esta consulta como concluída?';
                link = 'listar_consultas.php?acao=concluir&id=' + id;
                buttonColor = '#ff9800';
            }
            
            confirmTitle.textContent = title;
            confirmMessage.textContent = message;
            confirmLink.href = link;
            confirmLink.style.backgroundColor = buttonColor;
            confirmLink.style.color = 'white';
            confirmModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeConfirmModal() {
            confirmModal.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        // Modal de Edição
        const editModal = document.getElementById('editModal');
        
        function openEditModal(id, data, horario, procedimento) {
            document.getElementById('editId').value = id;
            document.getElementById('editData').value = data;
            document.getElementById('editHorario').value = horario;
            document.getElementById('editProcedimento').value = procedimento;
            editModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeEditModal() {
            editModal.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        // Fechar modais ao clicar fora
        window.onclick = function(event) {
            if (event.target == confirmModal) {
                closeConfirmModal();
            }
            if (event.target == editModal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>