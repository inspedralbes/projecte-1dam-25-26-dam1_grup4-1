<style>
    /* Aseguramos que el HTML y el BODY ocupen toda la altura */
    html,
    body {
        height: 100%;
        margin: 0;
    }

    /* Configuramos el body como un contenedor Flexbox vertical */
    body {
        display: flex;
        flex-direction: column;
    }

    /* El contenido principal (main o container) crecerá para ocupar el espacio */
    /* IMPORTANTE: Asegúrate de que todo tu contenido esté envuelto en una etiqueta <main> o un div */
    main,
    .content-wrapper {
        flex: 1 0 auto;
    }

    /* Estilos del footer */
    .site-footer {
        flex-shrink: 0;
        background-color: #567ba1;
        /* El azul oscuro que se ve en tu imagen */
        color: white;
        text-align: center;
        padding: 15px 0;
        width: 100%;
    }
</style>

<footer class="site-footer">
    <div class="container">
        <span>&copy; <?php echo date("Y"); ?> INS Pedralbes</span>
    </div>
</footer>

</body>

</html>