
<h1>Bonjour : <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Invité'; ?></h1><body>
<body>
    <form action="index.php" method="post">
        <label for="email">Email :</label>
        <input type="email" name="email" required>
    
    </form>
</body>