function reg(){
        var p1;
        var p2;

        p1 = document.getElementById('pw1').value;
        p2 = document.getElementById('pw2').value;
        if(p1 != p2)
        {
            alert("两次密码不一致");
            return;
        }

        document.getElementById('reg').submit();
}