<h1>Projeo desenvolvido por Wilson Soares</h1>

<h2>Descrição</h2>

<p>API para controle de gastos, registrando contas a pagar e a receber</p>

<h2>Funcionalidades</h2>

<ul>
  <li>registro de usuários;</li>
  <li>Registro de contas a pagar e receber;</li>
  <li>registro de tags(categorias).</li>
</ul>

<h2>Rotas da API</h2>

<h3><i>Usuários</i></h3>

<h4>Criação de novo usuário</h4>
<p><strong>POST -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/users</p>
<h4>Alteração de dados</h4>
<p><strong>PUT -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/users/{id}</p>
<h4>Exclusão da conta de usuário</h4>
<p><strong>DELETE -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/users/{id}</p>

<h4><strong>OBS: </strong>Dados necessários para o registro de usuário</h4>

<ul>
	<li>Name</li>
	<li>Email</li>
	<li>Password</li>
</ul>

<hr>

<h3><i>Tags</i></h3>

<h4>Criação de novas tags</h4>
<p><strong>POST -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/tags</p>
<h4>Alteração de dados</h4>
<p><strong>PUT -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/tags/{id}</p>
<h4>Exclusão da tag</h4>
<p><strong>DELETE -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/tags/{id}</p>

<h4><strong>OBS: </strong>Dados necessários para o registro de tags</h4>

<ul>
	<li>Descricao</li>
</ul>

<hr>

<h3><i>Lançamentos</i></h3>

<h4>Listagem de lançamentos</h4>
<p><strong>GET -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/registros</p>
<h4>Criação de novos lançamentos</h4>
<p><strong>POST -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/registros</p>
<h4>Alteração de dados</h4>
<p><strong>PUT -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/registros/{id}</p>
<h4>Exclusão da conta de lançamento</h4>
<p><strong>DELETE -</strong>  http://localhost/sistema-financeiro/laravel/public/api/v1/registros/{id}</p>
<h4>Baixa de lançamentos</h4>
<p><strong>PUT -</strong> http://localhost/sistema-financeiro/laravel/public/api/v1/baixas/{id}</p>

<h4><strong>OBS: </strong>Dados necessários para o registro de lançamentos</h4>

<ul>
	<li>Descrição</li>
	<li>Data_vencimento(0000-00-00)</li>
	<li>valor</li>
	<li>Tipo(D-Déito ou C-Crédito)</li>
	<li>Tags[](Não é obrigatório)</li>
</ul>

PS.:As tags são armazenadas em um array, por isso é importante colocar o "[]". Pode-se colocar mais de uma tag, desde que todas estejam devidamente cadastradas.

<hr>

<h3><i>Login e logout</i></h3>

<p><strong>POST -</strong> http://localhost/sistema-financeiro/laravel/public/api/v1/login</p>
<p><strong>GET -</strong> http://localhost/sistema-financeiro/laravel/public/api/v1/logout</p>
