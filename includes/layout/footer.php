<script language= javascript type= text/javascript >
    function changeInput(input) {
        console.log(input.files[0].name);
        document.querySelector('#nameFileSpan').innerHTML = input.files[0].name;
    }
</script>
</body>
</html>