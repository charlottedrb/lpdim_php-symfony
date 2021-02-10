<h1>
    <form method="POST" action="#">
        <input type="text" id="name" name="name" placeholder="Enter your name :)">
    </form>
    Hello <?= $name; ?>
</h1>
<script>
    let name = document.querySelector('#name')
    name.addEventListener('blur', () => {
        document.querySelector('form').submit();
    })

    document.addEventListener("keydown", function(event) {
        if (event.key === 'Enter') document.querySelector('form').submit()
    })

</script>
