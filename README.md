<h1>Projeo desenvolvido por Wilson Soares</h1>

<h2>Descrição</h2>

<p>API para controle de gastos, registrando contas a pagar e a receber</p>

<h2>Instalacao com Docker</h2>

<ul>
  <li>Aterar o nome do arquivo .env.example para .env</li>
  <li>docker-compose up -d</li>
  <li>php artisan migrate</li>
</ul>

<h2>Funcionalidades</h2>

<ul>
  <li>registro de usuários;</li>
  <li>Registro de contas a pagar e receber;</li>
  <li>registro de tags(categorias).</li>
</ul>

<h2>Rotas da API</h2>

<h3><i>Usuários</i></h3>
<h4>OBS: Todas as rotas estão no arquivo "financeiro.postman_collection.json"</h4>

<h4>Dados necessários para o registro de usuário</h4>

<ul>
	<li>Name</li>
	<li>Email</li>
	<li>Password</li>
</ul>

<hr>

<h3><i>Tags</i></h3>

<h4>Dados necessários para o registro de tags</h4>

<ul>
	<li>Descricao</li>
</ul>

<hr>

<h3><i>Lançamentos</i></h3>

<h4>Dados necessários para o registro de lançamentos</h4>

<ul>
	<li>Descrição</li>
	<li>Data_vencimento(0000-00-00)</li>
	<li>valor</li>
	<li>Tipo(D-Déito ou C-Crédito)</li>
	<li>Tags[](Não é obrigatório)</li>
</ul>

PS.:As tags são armazenadas em um array, por isso é importante colocar o "[]". Pode-se colocar mais de uma tag, desde que todas estejam devidamente cadastradas.
