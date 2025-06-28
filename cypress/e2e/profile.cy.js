describe('Gerenciamento de Perfil do Usuário', () => {
    // Cria um novo usuário "aluno" antes de todos os testes para garantir isolamento
    before(() => {
        // Usa um comando do artisan via sail para criar um usuário de teste
        // Isso é mais robusto do que depender de um usuário existente
        cy.exec('./vendor/bin/sail artisan tinker --execute="App\\Models\\User::factory()->create([\'name\' => \'Aluno Perfil Teste\', \'email\' => \'aluno.perfil@teste.com\', \'type\' => \'aluno\']);"');
    });

    beforeEach(() => {
        // Faz login como o aluno de teste
        cy.visit('/login');
        cy.get('input[id=email]').type('aluno.perfil@teste.com');
        cy.get('input[id=password]').type('password'); // A factory padrão cria com a senha 'password'
        cy.contains('button', 'Log in').click();
    });

    it('Deve permitir que o usuário atualize seu nome', () => {
        // Navega para a página de perfil
        cy.contains('nav a', 'Meu Álbum').should('be.visible'); // Confirma que logou como aluno
        cy.get('button').contains('Aluno Perfil Teste').click(); // Abre o dropdown do usuário
        cy.contains('a', 'Perfil').click();

        cy.url().should('include', '/profile');

        const novoNome = `Aluno Perfil Editado ${Date.now()}`;

        // Altera o nome e salva
        cy.get('input[id=name]').clear().type(novoNome);
        cy.get('button').contains('Save').click();

        // Verifica a mensagem de sucesso e se o nome foi atualizado no topo da página
        cy.contains('p', 'Saved.').should('be.visible');
        cy.get('button').contains(novoNome);
    });

    it('Deve permitir que o usuário atualize sua senha', () => {
        // Navega para a página de perfil
        cy.get('button').contains('Aluno Perfil').click(); // Nome pode ter sido editado
        cy.get('a').contains('Perfil').click();

        // Preenche o formulário de atualização de senha
        cy.get('input[id=current_password]').type('password');
        cy.get('input[id=password]').type('new-password-123');
        cy.get('input[id=password_confirmation]').type('new-password-123');

        cy.get('form').contains('button', 'Save').click();

        // Verifica a mensagem de sucesso
        cy.contains('p', 'Saved.').should('be.visible');
    });
});
