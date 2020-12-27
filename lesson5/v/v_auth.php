<?php if(isset($_COOKIE['name'])): header('Location:index.php?c=user&act=personal');?>

<?php else: ?>
    <form method="post">
        <input type="login" placeholder="Username" name="login" required>
        <br>
        <br>
        <input type="password" placeholder="Password" name="pass" required>
        <br>
        <br>
        <input type="submit" value="Сохранить" />
    </form>
<?php endif; ?>


