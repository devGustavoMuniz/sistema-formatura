describe('Gerenciamento de Perfil do Usuário', () => {
    let userName;
    let userEmail;
    let novoNome;

    before(() => {
        // Gera dados de usuário únicos para cada execução de teste
        const timestamp = Date.now();
        userName = `Aluno Perfil ${timestamp}`;
        userEmail = `aluno.perfil.${timestamp}@teste.com`;
        novoNome = `Aluno Editado ${timestamp}`;

        // Usa um comando do artisan via sail para criar um usuário de teste
        // Isso é mais robusto do que depender de um usuário existente no banco de dados
        cy.exec(`./vendor/bin/sail artisan tinker --execute="App\\Models\\User::factory()->create(['name' => '${userName}', 'email' => '${userEmail}', 'type' => 'aluno']);"`);
    });

    beforeEach(() => {
        // Faz login como o aluno de teste recém-criado
        cy.visit('/login');
        cy.get('input[id=email]').type(userEmail);
        cy.get('input[id=password]').type('password'); // A factory padrão cria com a senha 'password'
        cy.contains('button', 'Log in').click();
    });

    it('Deve permitir que o usuário atualize seu nome e senha', () => {
        // --- 1. ETAPA DE ATUALIZAÇÃO DO NOME ---
        // Garante que o usuário está logado (verificando um elemento da página de aluno)
        cy.contains('nav a', 'Meu Álbum').should('be.visible');

        // Usa um seletor mais específico para o botão do dropdown do usuário na barra de navegação principal
        // Isso evita clicar no botão do menu responsivo por engano
        cy.get('.hidden.sm\\:flex button').contains(userName).click();
        cy.contains('a', 'Perfil').click();

        cy.url().should('include', '/profile');

        // Altera o nome e salva
        cy.get('input[id=name]').clear().type(novoNome);
        cy.get('form').contains('button', 'Save').click();

        // Verifica a mensagem de sucesso
        cy.contains('p', 'Saved.').should('be.visible');

        // ---- CORREÇÃO ----
        // Recarrega a página para garantir que a alteração foi persistida no servidor
        // e que o layout é renderizado com os novos dados.
        cy.reload();

        // Verifica se o nome foi atualizado no topo da página após o recarregamento
        cy.get('.hidden.sm\\:flex button').contains(novoNome).should('be.visible');

        // --- 2. ETAPA DE ATUALIZAÇÃO DA SENHA ---
        // A página de perfil já está aberta (foi recarregada), então vamos direto para o formulário de senha
        cy.get('input[id=current_password]').type('password');
        cy.get('input[id=password]').type('new-password-123');
        cy.get('input[id=password_confirmation]').type('new-password-123');

        // Usa um seletor mais específico para o botão Salvar do formulário de senha para evitar ambiguidade
        cy.get('form:last-of-type').contains('button', 'Save').click();

        // Verifica a mensagem de sucesso
        cy.contains('p', 'Saved.').should('be.visible');
    });
});
