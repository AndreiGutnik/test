<h1>Регистрация</h1>
%message%
<div id="reg">
<form name="reg" action="functions.php" method="post">
    <table>
        <tr>
            <td>Имя:</td>
            <td> 
                <input type="text" name="login" value="%login%" />
            </td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td>
                <input type="password" name="password" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <img src="captcha.php" alt="капча" />
            </td>
        </tr>
        <tr>
            <td>Проверочный код:</td>
            <td>
                <input type="text" name="сaptcha" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="submit" name="reg" value="Зарегистрироваться" />
            </td>
        </tr>
    </table>
</form>
</div><!-- end reg-->