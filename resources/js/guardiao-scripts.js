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


window.mostrarCarregando = function (event, provedor) {
    event.preventDefault();
    const url = event.currentTarget.href;
    const statusDiv = document.getElementById('status-login');
    const msgTexto = document.getElementById('mensagem-dinamica');

    if (statusDiv && msgTexto) {
        statusDiv.classList.remove('hidden');
        msgTexto.innerText = `Conectando ao ${provedor}...`;

        setTimeout(() => {
            msgTexto.innerText = "Validando LGPD e Segurança...";
            setTimeout(() => { window.location.href = url; }, 1000);
        }, 1000);
    }
};

function validarCadastro(event) {
    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');
    const erro8 = document.getElementById('erro-senha-8');
    const erroConf = document.getElementById('erro-confirmacao');

    password.classList.remove('border-red-500');
    confirmation.classList.remove('border-red-500');
    erro8.classList.add('hidden');
    erroConf.classList.add('hidden');

    let erro = false;

    if (password.value.length < 8) {
        alert("⚠️ A senha deve ter pelo menos 8 caracteres.");
        password.classList.add('border-red-500');
        erro8.classList.remove('hidden');
        password.focus();
        erro = true;
    }
    else if (password.value !== confirmation.value) {
        alert("⚠️ As senhas digitadas são diferentes.");
        confirmation.classList.add('border-red-500');
        erroConf.classList.remove('hidden');
        confirmation.focus();
        erro = true;
    }

    if (erro) {
        event.preventDefault();
        return false;
    }

    return true;
}

function toggleContraste() {
    document.body.classList.toggle('alto-contraste');
    const ativo = document.body.classList.contains('alto-contraste');
    localStorage.setItem('contraste', ativo);
}

let tamanhoFonte = 100; 
function mudarFonte(acao) {
    const el = document.documentElement; /
    if (acao === 'aumentar' && tamanhoFonte < 150) tamanhoFonte += 10;
    if (acao === 'diminuir' && tamanhoFonte > 80) tamanhoFonte -= 10;
    el.style.fontSize = tamanhoFonte + "%";
}

window.onload = function() {
    if (localStorage.getItem('contraste') === 'true') {
        document.body.classList.add('alto-contraste');
    }
};