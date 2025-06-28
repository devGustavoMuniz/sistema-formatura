describe('Gerenciamento completo de Instituições', () => {
    // Variáveis para compartilhar dados entre as etapas do teste
    let instituteName;
    let cnpj;
    let novoNome;

    before(() => {
        // Gera dados únicos apenas uma vez antes de todos os testes
        const timestamp = Date.now();
        instituteName = `Universidade Cypress ${timestamp}`;
        novoNome = `Instituto Editado ${timestamp}`;
        // Gera um CNPJ válido e único para cada execução
        cnpj = `${timestamp}`.substring(0, 14).padStart(14, '0');
    });

    beforeEach(() => {
        // O login é executado antes de cada 'it'
        cy.visit('/login');
        cy.get('input[id=email]').type('admin@example.com');
        cy.get('input[id=password]').type('password');
        cy.contains('button', 'Log in').click();
        cy.url().should('include', '/admin/dashboard');
    });

    it('Deve criar, editar e excluir uma instituição, usando a busca para verificação', () => {
        // --- 1. ETAPA DE CRIAÇÃO ---
        cy.visit('/admin/institutes/create');
        cy.get('input[id=name]').type(instituteName);
        cy.get('input[id=cnpj]').type(cnpj);
        cy.get('input[id=address]').type('Avenida dos Testes Automatizados, 123');
        cy.contains('button', 'Salvar').click();

        // --- VERIFICAÇÃO DA CRIAÇÃO (USANDO A BUSCA) ---
        cy.url().should('include', '/admin/institutes');
        cy.get('input[type="search"]').type(instituteName);
        cy.get('table > tbody > tr').should('have.length', 1);
        cy.contains('td', instituteName).should('be.visible');

        // --- 2. ETAPA DE EDIÇÃO ---
        cy.contains('td', instituteName).parent('tr').within(() => {
            cy.get('button[aria-haspopup="menu"]').click();
        });
        cy.contains('[role="menuitem"]', 'Editar').click();

        cy.url().should('include', '/edit');
        cy.get('input[id=name]').clear().type(novoNome);
        cy.contains('button', 'Atualizar').click();

        // --- VERIFICAÇÃO DA EDIÇÃO (USANDO A BUSCA) ---
        cy.url().should('include', '/admin/institutes');
        cy.get('input[type="search"]').clear().type(novoNome);
        cy.get('table > tbody > tr').should('have.length', 1);
        cy.contains('td', novoNome).should('be.visible');

        // --- 3. ETAPA DE EXCLUSÃO ---
        cy.contains('td', novoNome).parent('tr').within(() => {
            cy.get('button[aria-haspopup="menu"]').click();
        });
        // Usamos .last() para garantir que estamos clicando no menuitem correto se a página recarregar
        cy.contains('[role="menuitem"]', 'Excluir').last().click();

        cy.get('[role="alertdialog"]').should('be.visible');
        cy.contains('button', 'Confirmar').click();

        // --- VERIFICAÇÃO DA EXCLUSÃO (USANDO A BUSCA) ---
        // A página pode recarregar, então a busca garante que estamos olhando o estado final
        cy.get('input[type="search"]').clear().type(novoNome);
        cy.get('table > tbody > tr').should('not.exist');
    });
});
