<link rel="stylesheet" type="text/css"
      href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
    window.addEventListener("load", function () {
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#252e39"
                },
                "button": {
                    "background": "#14a7d0"
                }
            },
            "position": "bottom",
            "content": {
                "message": "Este sitio web utiliza cookies para ofrecer el 100% de su funcionalidad.",
                "dismiss": "Entendido",
                "link": "Más información",
                "href": "{{url('/pagina/aviso-legal-y-cookies')}}"
            }
        })
    });
</script>