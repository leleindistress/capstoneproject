<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('style.css')}}">
</head>

<body background="white" id="loginPage">
    <div class="container" id="formcard">
        <center>
            <h1>TWO-FACTOR AUTHENTICATION</h1>
        </center>
        <div class="container" id="codeForm">
            <form method="POST" action='two_factor_authentication_process.php'>
                <center>
                    <p>A four-digit code has been sent to your email. Enter the code below:</p>
                </center>
                <div class="d-flex justify-content-center">
                    <input type="text" pattern="[0-9]" class="form-control mx-1" id="code1" maxlength="1" name='code1' onkeyup="moveToNext(this, 'code2')">
                    <input type="text" pattern="[0-9]" class="form-control mx-1" id="code2" maxlength="1" name='code2' onkeyup="moveToNext(this, 'code3')">
                    <input type="text" pattern="[0-9]" class="form-control mx-1" id="code3" maxlength="1" name='code3' onkeyup="moveToNext(this, 'code4')">
                    <input type="text" pattern="[0-9]" class="form-control mx-1" id="code4" maxlength="1" name='code4'>
                </div>
                <div id="wrong-code-alert"></div>
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-primary" id="verifyButton" value="Verify">Verify</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        function moveToNext(currentInput, nextInputId) {
            if (currentInput.value.length == currentInput.maxLength) {
                document.getElementById(nextInputId).focus();
            }
        }
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const inputtedCode = document.getElementById('code1').value + document.getElementById('code2').value + document.getElementById('code3').value + document.getElementById('code4').value;

            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if (this.responseText.trim() == 'correct code') {
                    window.location.href = '../Dashboard/dashboard.php';
                } else {
                    console.log(this.responseText);
                    const wrong_code_alert = document.querySelector('#wrong-code-alert');
                    const wrong_code = document.createElement('div');
                    wrong_code.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show');
                    wrong_code.setAttribute('role', 'alert');
                    wrong_code.setAttribute('id', 'wrong-code');
                    wrong_code.innerHTML = 'You have entered the wrong code.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="wrong-code-dismiss"></button>';
                    wrong_code_alert.insertBefore(wrong_code, wrong_code_alert.firstChild);
                }
            }
            xhttp.open('POST', 'two_factor_authentication_process.php');
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send(`code=${inputtedCode}`);
        });
    </script>
</body>

</html>