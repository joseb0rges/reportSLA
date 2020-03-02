
# reportSLA

##Aplicação de relatório, que tem por finalidade exibir e exportar o SLA do zabbix de acordo com grupo (Parente Service) e período selecionado, utilizando a api do zabbix, algo que se for feito pela interface web do proprio zabbix acaba sendo bem restrito.

###### INSTRUÇÕES

- CONFIGURAR O CONECTOR API

*Para se conectar ao zabbix, altere o arquivo connect_zabbix.php, informando usuário e senha do mesmo.*

- CONFIGURANDO SEU FILTRO DE PARANT SERVICE

*Para que seu relatório exiba as informações do sla, altere seu paramentro de filtro para seus parents services, se os mesmos não começarem com a letra R no arquivo SLA.php, no metodo getNameParent().*

- **METODOS EXTRAS**

*Estou a desenvolver o relatório de eventos que informa quais eventos causaram o decremento no SLA durante aquele mês selecionado, os mesmos já estão disponibilizados nesse projeto, são eles: searchEventClock(), searchEventperHostid(), **calcDuractionEvent()** .*
