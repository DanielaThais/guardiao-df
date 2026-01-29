async function enviarFormulario(idForm, url, callbackSucesso) {
    const form = document.getElementById(idForm);
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(form);
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> Processando...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                callbackSucesso(data);
            } else {
                alert('Erro: ' + (data.message || 'Verifique os dados enviados.'));
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    enviarFormulario('formCadastro', '/cadastro', (data) => {
        alert('Usuário criado com sucesso!');
        window.location.href = data.redirect;
    });

    enviarFormulario('formScan', '/scan', (data) => {
        document.getElementById('areaResultado').innerHTML = data.html_resultado;
        alert('Análise concluída!');
        document.querySelector('#formScan button').disabled = false;
    });
});