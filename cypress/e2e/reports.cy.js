describe('Funcionalidade de Relatórios', () => {
    beforeEach(() => {
        // Loga como administrador para acessar a área restrita
        cy.visit('/login');
        cy.get('input[id=email]').type('admin@example.com');
        cy.get('input[id=password]').type('password');
        cy.contains('button', 'Log in').click();
        cy.url().should('include', '/admin/dashboard');
    });

    it('Deve gerar um relatório de Alunos por Instituição', () => {
        // Navega para a página de relatórios
        cy.visit('/admin/reports');
        cy.contains('h2', 'Relatórios Gerenciais');

        // Clica no seletor para abrir as opções
        cy.get('button[role="combobox"]').click();

        // Clica na opção "Alunos por Instituição"
        cy.get('[role="option"]').contains('Alunos por Instituição').click();

        // Clica no botão para gerar o relatório
        cy.contains('button', 'Gerar Relatório').click();

        // Verifica se o título do relatório correto foi exibido
        cy.contains('h3', 'Resultado: Alunos por Instituição').should('be.visible');

        // Verifica se a tabela de resultados foi renderizada com os cabeçalhos esperados
        cy.get('table').should('be.visible');
        cy.get('table th').contains('Instituição');
        cy.get('table th').contains('Total de Alunos');
    });

    it('Deve gerar um relatório de Fotos por Aluno', () => {
        // Navega para a página de relatórios
        cy.visit('/admin/reports');
        cy.contains('h2', 'Relatórios Gerenciais');

        // Abre o seletor e escolhe a opção "Fotos por Aluno"
        cy.get('button[role="combobox"]').click();
        cy.get('[role="option"]').contains('Fotos por Aluno').click();

        // Gera o relatório
        cy.contains('button', 'Gerar Relatório').click();

        // Verifica o título e os cabeçalhos da tabela de resultados
        cy.contains('h3', 'Resultado: Fotos por Aluno').should('be.visible');
        cy.get('table').should('be.visible');
        cy.get('table th').contains('Aluno');
        cy.get('table th').contains('Total de Fotos');
    });
});
