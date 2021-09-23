    <div class="w3-container w3-card-4">
        <h3>Painel Administrativo</h3>
        <p><?php echo $_SESSION['usuNome']; ?></p>
        <a class="w3-button w3-blue" href="principal.php?action=musicas">Músicas</a>
        <a class="w3-button w3-blue" href="principal.php?action=integrantes">Integrantes</a>
        <a class="w3-button w3-blue" href="principal.php?action=grupos">Grupos</a>
        <a class="w3-button w3-blue" href="principal.php?action=escalas">Escalas</a>
        <a class="w3-button w3-blue" href="principal.php?action=logout">Sair</a>
        <br><br>
    </div>