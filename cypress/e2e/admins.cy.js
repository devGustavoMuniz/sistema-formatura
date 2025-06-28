describe('Gerenciamento de Administradores', () => {
    // Bloco que executa antes de cada teste
    beforeEach(() => {
        // Faz login como o administrador principal para poder gerenciar outros
        cy.visit('/login');
        cy.get('input[id=email]').type('admin@example.com');
        cy.get('input[id=password]').type('password');
        cy.contains('button', 'Log in').click();
        cy.url().should('include', '/admin/dashboard');
    });

    it('Deve criar um novo administrador e depois excluí-lo, verificando sua presença na lista', () => {
        // --- 1. ETAPA DE CRIAÇÃO ---
        cy.visit('/admin/admins/create');
        cy.contains('h2', 'Cadastrar Novo Administrador');

        // Preenche o formulário com dados únicos
        const timestamp = Date.now();
        const adminName = `Admin Teste ${timestamp}`;
        const adminEmail = `admin.teste.${timestamp}@example.com`;

        cy.get('input[id=name]').type(adminName);
        cy.get('input[id=email]').type(adminEmail);
        cy.get('input[id=password]').type('password123');
        cy.get('input[id=password_confirmation]').type('password123');
        cy.contains('button', 'Salvar').click();

        // --- 2. VERIFICAÇÃO DA CRIAÇÃO ---
        cy.url().should('include', '/admin/admins');
        // A página de Admins não tem busca, então vamos procurar o admin na tabela.
        // Se houver muitas páginas, este teste pode se tornar instável no futuro.
        // A melhor solução a longo prazo seria adicionar um campo de busca a esta tela.
        cy.contains('td', adminName).should('be.visible');

        // --- 3. ETAPA DE EXCLUSÃO ---
        // Encontra a linha do administrador que acabamos de criar e clica em excluir
        cy.contains('td', adminName).parent('tr').within(() => {
            cy.contains('button', 'Excluir').click();
        });

        // Confirma a exclusão na caixa de diálogo
        cy.get('[role="alertdialog"]').should('be.visible');
        cy.contains('button', 'Confirmar').click();

        // --- 4. VERIFICAÇÃO DA EXCLUSÃO ---
        // Após a exclusão, o admin não deve mais existir na tabela
        cy.contains('td', adminName).should('not.exist');
    });
});
