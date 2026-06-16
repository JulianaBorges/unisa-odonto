<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Paciente - Clínica Odontológica</title>
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

        /* Card do formulário */
        .form-card {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 150px);
        }

        form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 550px;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #667eea;
            font-size: 1.8rem;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 0.9rem;
        }

        input, select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e1e5eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            font-family: inherit;
        }

        input:hover, select:hover {
            border-color: #764ba2;
        }

        input:focus, select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #999;
            font-weight: 400;
        }

        /* Estilo para o campo date */
        input[type="date"] {
            color: #555;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: invert(0.5);
        }

        /* Botões */
        .btn-salvar {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-salvar:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-salvar:active {
            transform: translateY(0);
        }

        .btn-voltar {
            width: 100%;
            padding: 12px;
            background: #f8f9fa;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-voltar:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Alertas */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
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

        /* Responsivo com Menu Hambúrguer */
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

            form {
                padding: 30px 20px;
                margin: 20px;
            }
            
            input, .btn-salvar, .btn-voltar {
                padding: 12px 14px;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .nav-links {
                width: 85%;
            }

            .nav-links a {
                padding: 6px 12px;
                font-size: 0.9rem;
            }

            .form-title {
                font-size: 1.3rem;
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

        <!-- Formulário -->
        <div class="form-card">
            <form method="POST">
                <h2 class="form-title">📝 Cadastro de Paciente</h2>
                
                <?php
                include 'conexao.php';
                
                if(isset($_POST['salvar'])){
                    // Validação básica
                    $erros = [];
                    
                    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
                    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
                    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $data = mysqli_real_escape_string($conn, $_POST['data_nascimento']);
                    
                    // Verificar se campos estão vazios
                    if(empty($nome)) $erros[] = "Nome é obrigatório";
                    if(empty($cpf)) $erros[] = "CPF é obrigatório";
                    if(empty($telefone)) $erros[] = "Telefone é obrigatório";
                    if(empty($email)) $erros[] = "Email é obrigatório";
                    if(empty($data)) $erros[] = "Data de nascimento é obrigatória";
                    
                    // Verificar formato do email
                    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $erros[] = "Email inválido";
                    }
                    
                    // Verificar se CPF já existe
                    $check_cpf = mysqli_query($conn, "SELECT id FROM pacientes WHERE cpf = '$cpf'");
                    if(mysqli_num_rows($check_cpf) > 0) {
                        $erros[] = "CPF já cadastrado no sistema";
                    }
                    
                    // Se não houver erros, cadastrar
                    if(empty($erros)) {
                        $sql = "INSERT INTO pacientes (nome, cpf, telefone, email, data_nascimento) 
                                VALUES ('$nome', '$cpf', '$telefone', '$email', '$data')";
                        
                        if(mysqli_query($conn, $sql)) {
                            echo '<div class="alert alert-success">';
                            echo '✅ Paciente cadastrado com sucesso!';
                            echo '</div>';
                            // Limpar formulário após sucesso
                            echo '<script>setTimeout(function(){ window.location.href = "cadastrar_paciente.php"; }, 2000);</script>';
                        } else {
                            echo '<div class="alert alert-error">';
                            echo '❌ Erro ao cadastrar: ' . mysqli_error($conn);
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-error">';
                        echo '❌ Por favor, corrija os seguintes erros:<br>';
                        foreach($erros as $erro) {
                            echo '• ' . $erro . '<br>';
                        }
                        echo '</div>';
                    }
                }
                ?>
                
                <div class="input-group">
                    <label>👤 Nome Completo</label>
                    <input type="text" name="nome" placeholder="Digite o nome completo" required value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label>🆔 CPF</label>
                    <input type="text" name="cpf" placeholder="000.000.000-00" required value="<?php echo isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label>📞 Telefone</label>
                    <input type="text" name="telefone" placeholder="(00) 00000-0000" required value="<?php echo isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label>📧 Email</label>
                    <input type="email" name="email" placeholder="exemplo@email.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label>🎂 Data de Nascimento</label>
                    <input type="date" name="data_nascimento" required value="<?php echo isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : ''; ?>">
                </div>
                
                <button type="submit" name="salvar" class="btn-salvar">💾 Cadastrar Paciente</button>
                <a href="listar_consultas.php" class="btn-voltar">← Voltar para Consultas</a>
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
    </script>
</body>
</html>