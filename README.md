# Repositorio Sistemas de Ordem de Serviços

O Sistema de Ordem de Serviços é apresentado contemplando suas características técnicas como: a sua arquitetura, funcionalidades, estrutura do banco de dados
e funcionamento. A arquitetura utilizada para o desenvolvimento do sistema será uma instância do modelo de arquitetura em camadas, o MVC (Model View and Controller, ou Modelo, Visão e
Controle). Este é um padrão de projeto que consiste em três objetos em que o Model é o objeto de aplicação, o View é sua tela de aplicação e o Controller define o modo que a
interface de usuário reage as suas entradas (GAMMA, 1995). A utilização desse modelo é bastante difundida na modelagem de sistemas,
principalmente em aplicações Web, o que traz consigo diversas vantagens, tais como:

- Desenvolver e modificar uma camada sem alterar o estado das demais;
- Dividida em componentes com o mesmo nível de abstração;
- Facilidade de manutenção;
- Facilidade de expansão do sistema;

Como forma de apresentar as funcionalidades do sistema foi elaborado um diagrama de casos de uso.

![](https://github.com/willamys/os_/blob/master/UseCase%20Diagram-%20OS.png)

Os casos de uso são uma técnica para captar requisitos 
funcionais de um sistema. Eles servem para descrever as interações típicas entre os usuários de um sistema e o próprio sistema, fornecendo uma narrativa sobre o sistema utilizado (FOWLER, 2005). Dessa forma,
o diagrama permite uma visualização melhor de como o sistema funciona, apresentando quais ações os atores podem realizar. Na Apêndice A, é possível analisar os Atores e os Casos de Uso associados a eles. É notório que algumas funcionalidades não podem ser acessadas por ambos. Um exemplo é o
“Cadastrar Solicitante” que só poderá ser utilizada pelo Administrador, permitindo maior segurança ao sistema. 

Em Sommerville (2005) os requisitos funcionais descrevem a funcionalidade ou os serviços que se espera que o sistema forneça. Já os requisitos não funcionais, não dizem
respeito diretamente às funções específicas fornecidas pelo sistema, estes podem estar relacionados à confiabilidade, a portabilidade, facilidade de uso, segurança, 
dentre outros.
 
Uma forma de apresentar a estrutura do banco de dados é através do Diagrama deEntidade-Relacionamento (DER). Em Elmasri (2011) o DER é uma notação diagramática do
modelo de Entidade Relacionamento (ER), modelo conceitual popular de alto nível que costuma ser utilizado para o projeto conceitual de aplicações de banco de dados.
No DER, as entidades representadas irão se tornar as tabelas do banco de dados, junto com os seus atributos, que serão as colunas. 
Outra informação mostrada é a interação entre as entidades. Dessa forma, essa representação permite saber como o banco de dados será projetado.

![](https://github.com/willamys/os_/blob/master/Diagrama%20E-R%20OS.jpg)

Após se autenticar ao sistema, o usuário é redirecionado para a tela inicial.

![](https://github.com/willamys/os_/blob/master/Untitled-1.png)

Como forma de melhor evidenciar as funcionalidades do sistema, a figura foi dividida em partes com cores e numeração.
- Na área 1, em vermelho, é mostrado o e-mail do usuário que está autenticado no sistema e o link para alterar a sua senha.
- Na área 2, em azul, apresenta uma barra com as opções de criar uma Nova OS, um Novo Solicitante, Editar Solicitante, Novo Equipamento.
- Na área 3, em rosa, uma tabela apresenta as ordens de serviço que estão abertas/em andamento, assim como o solicitante, data da criação, dentre outras informações.
- Na área 4, em laranja, algumas opções são mostradas, o tem a função de gerar o arquivo no formato PDF da Ordem de Serviço; o tem a função de permitir a visualização
da OS com mais detalhes; o permite o usuário, desde que administrador, efetuar mudança na OS; e por fim o admite excluir a OS, mas somente se autenticado como administrador.

Como foi visto na imagem anterior, existe o botão Nova OS que aciona a página de cadastro imagem abaixo. Uma vez que o solicitante finalizar o preenchimento dos campos e
clicar em Ok, um e-mail é disparado para o setor de TI, na figura do Coordenador de TI, que irá alocar um técnico de TI para atender essa demanda. Quando o técnico de TI é alocado para
o serviço, via sistema, tanto o técnico quanto o solicitante recebem uma notificação por e-mail informando o status da solicitação.

![](https://github.com/willamys/os_/blob/master/apendiceE.png)
