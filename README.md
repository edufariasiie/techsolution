# TechSolution Versão 2

## Status do Projeto

[=----------------]

O projeto está atualmente em 5% de conclusão.

## Visão Geral

O TechSolution é uma plataforma que conecta estudantes a membros da comunidade (ONGs, projetos sociais, pequenas empresas e MEIs) para colaboração em projetos práticos, promovendo aprendizado, colaboração e impacto social. A versão 4 introduz um modelo de monetização sustentável com planos gratuitos e pagos, funcionalidades de grupos, recompensas, badges, rankings e uma área administrativa para gerenciar. Acesse o projeto em [techsolution.siie.com.br](http://techsolution.siie.com.br).

## Funcionalidades

### Planos para Membros da Comunidade:
- **Free (ONGs):** 3 projetos/mês, com escolha de candidatos.
- **Free (MEI):** 1 projeto/mês, primeiro a aceitar leva.
- **Intermediário (R$ 12/mês):** 2 projetos/mês, sem escolha de candidatos.
- **Full (R$ 15/mês):** 3 projetos/mês, com escolha de candidatos.

### Planos para Estudantes:
- **Free:** 1 projeto com recompensa financeira/mês, 3 concluídos/mês, vê projetos.
- **Pago (R$ 5/mês):** Projetos com recompensa ilimitados, 3 concluídos/mês, vê apenas projetos reais.

### Outras Funcionalidades:
- **Grupos:** Estudantes no plano pago podem formar grupos (até 5 membros) para candidaturas colaborativas.
- **Recompensas:** Membros definem recompensas (financeiras ou não); recompensas melhores atraem estudantes mais rápido.
- **Feedback:** Membros fornecem feedback e avaliações (estrelas) para projetos concluídos (individual e em grupo).
- **Badges:** Conquistados por marcos (ex.: "Estrela de Soluções" por 3 projetos).
- **Rankings:** Placar simplificado para desempenho geral.

## Tecnologias Utilizadas

- **Backend:** PHP
- **Banco de Dados:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Segurança:** Bcrypt para hash de senhas, autenticação baseada em sessões

## Estrutura do Banco de Dados

### Tabelas principais:
- **usuarios:** Dados do usuário (id, nome, periodo, especialidades, plano, data_assinatura, role)
- **projetos:** Detalhes do projeto (id, titulo, descricao, publicado_por, recompensa, recompensa_por, data_publicacao)
- **projetos_aceitos:** Projetos aceitos (id, projeto_id, usuario_id, grupo_id, status, data_aceitacao)
- **grupos:** Informações do grupo (id, nome_grupo, especialidades, criador_id)
- **grupo_membros:** Membros do grupo (id, grupo_id, usuario_id)
- **feedback:** Dados de feedback (id, projeto_id, usuario_id, grupo_id, feedback, estrelas)
- **badges & usuario_badges:** Definições e atribuições de badges
- **pontuacao:** Pontuações para rankings

## Instruções de Configuração

1. **Clonar o Repositório:**
   ```bash
   git clone https://github.com/usuario/techsolution-v4.git
   ```

2. **Instalar Dependências:**
   - Certifique-se de ter PHP (>= 7.4) e MySQL instalados.
   - Não são necessárias bibliotecas adicionais para a configuração básica.

3. **Configurar o Banco de Dados:**
   - Crie um banco de dados MySQL.
   - Execute o script SQL em `database/schema.sql` para criar as tabelas e inserir dados iniciais de teste (1 admin, 1 estudante, 1 membro da comunidade).

4. **Configurar o Ambiente:**
   - Copie `config.example.php` para `config.php` e atualize as credenciais do banco.

   ```php
   <?php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'seu_usuario');
   define('DB_PASS', 'sua_senha');
   define('DB_NAME', 'techsolution');
   ?>
   ```

5. **Executar a Aplicação:**
   - Hospede em um servidor compatível com PHP (ex.: Apache, Nginx, ou use `php -S localhost:8000`).
   - Acesse `login.php` no navegador.

## Credenciais Padrão

- **Admin:** admin@example.com / password (role: admin)
- **Estudante:** student@example.com / password (role: aluno)
- **Membro:** member@example.com / password (role: membro_comunidade)

## Páginas Principais

- **login.php:** Login unificado com redirecionamento por role.
- **admin.php:** Dashboard do admin para gerenciar o sistema.
- **projetosDisponiveis.php:** Lista projetos disponíveis.
- **perfil.php:** Perfil do estudante (editar periodo, especialidades, ver feedback/badges).
- **grupo_perfil.php:** Perfil do grupo (feedback, badges futuros).
- **publicar_projeto.php:** Criação de projetos com configuração de recompensas.
- **comFinished.php:** Finalização de projetos e envio de feedback.
- **ranking.php:** Placar simplificado.

## Plano de Desenvolvimento

O projeto foi desenvolvido em 6 fases ao longo de ~1,5 mês (42-45 dias):

1. **Estrutura Base e Autenticação (Dias 1-5):** Banco de dados, login, dashboards básicos.
2. **Planos e Publicação de Projetos (Dias 6-12):** Planos de membros, criação de projetos.
3. **Estudantes e Aceitação de Projetos (Dias 13-21):** Perfis de estudantes, lógica de aceitação.
4. **Grupos e Feedback (Dias 22-29):** Funcionalidade de grupos, sistema de feedback.
5. **Área de Admin (Dias 30-35):** Dashboard do admin, lógica de projetos.
6. **Badges, Rankings e Polimento (Dias 36-45):** Gamificação simplificada, refinamento de UI.

## Testes

### Testes Principais:
- Login com diferentes roles (admin, estudante, membro).
- Publicar projetos e verificar limites de planos (ex.: 4º projeto bloqueado para Free ONG).
- Aceitar projetos e verificar limites (ex.: 2º projeto com recompensa no Free exibe aviso).
- Criar grupos e candidatar-se como grupo (apenas plano pago).
- Enviar feedback para projetos individuais e em grupo.
- Conquistar badges e atualizar rankings.

**Ferramentas:** Testes manuais; integração futura com PHPUnit recomendada.

## Melhorias Futuras

- Integração de pagamento (ex.: PagSeguro, Mercado Pago).
- Controles de visibilidade para perfis de grupo.
- Sistema de badges expandido para grupos.
- Aprovação automatizada de planos na área de admin.
- Testes unitários para fluxos críticos.

## Como Contribuir

1. Faça um fork do repositório.
2. Crie um branch para sua funcionalidade:
   ```bash
   git checkout -b feature/sua-funcionalidade
   ```
3. Faça commit das alterações:
   ```bash
   git commit -m "Adiciona sua funcionalidade"
   ```
4. Envie para o branch:
   ```bash
   git push origin feature/sua-funcionalidade
   ```
5. Abra um Pull Request.

## Licença

Este projeto está licenciado sob a Licença MIT. Veja o arquivo LICENSE para detalhes.

## Contato

Para problemas ou sugestões, abra uma issue no GitHub ou contate o mantenedor em [techsolution.siie.com.br](http://techsolution.siie.com.br).