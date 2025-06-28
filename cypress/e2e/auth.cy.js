describe('Funcionalidades de Autenticação', () => {
    it('Deve permitir que um administrador faça login com sucesso', () => {
        // Visita a página de login
        cy.visit('/login');

        // Preenche o formulário de login
        // Use um email de administrador que exista no seu banco de dados de teste
        cy.get('input[id=email]').type('admin@example.com');
        cy.get('input[id=password]').type('password');

        // Clica no botão de login
        cy.contains('button', 'Log in').click();

        // Verifica se foi redirecionado para o dashboard de admin
        cy.url().should('include', '/admin/dashboard');

        // Verifica se o nome do usuário aparece no layout autenticado
        cy.contains('Admin User');
    });
});
