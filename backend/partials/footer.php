</main>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    :root {
        --primary-color: rgb(44, 79, 86);
        --white: #ffffff;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: var(--primary-color);
        color: var(--white);
        font-size: 14px;
        letter-spacing: 0.5px;
        box-shadow: 0 -2px 6px rgba(0,0,0,0.05);
        margin-top: auto; /* ⬅️ Ini penting untuk sticky di bawah */
    }

    footer p {
        margin: 0;
    }
</style>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Dealer Mobil. All rights reserved.</p>
</footer>

</body>
</html>
