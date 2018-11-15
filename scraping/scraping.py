# This Python file uses the following encoding: utf-8

# Trabalho OA Navs: Lourdescraping
# Por Rafael do Couto Pito, Ulisses de Souza Melo e Willian Hideki Kawabata

# Vars!
debug = True

# Libs!
import requests
import pandas
import re
from bs4 import BeautifulSoup
from openpyxl import Workbook
import mysql.connector
import time

# Timestamp
ts = str(int(time.time()))
tablename = "scrap_" + ts

# Defs!
def remove_prefix(text, prefix):
    if text.startswith(prefix):
        return text[len(prefix):]
    return text

# Lista com links para iterar
links = [
	[
		"https://sp.olx.com.br/sao-paulo-e-regiao/imoveis/aluguel?f=p",
		"11",
		"Particular"
	],
	[
		"https://sp.olx.com.br/sao-paulo-e-regiao/imoveis/aluguel?f=c",
		"11",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/vale-do-paraiba-e-litoral-norte/imoveis/aluguel?f=p",
		"12",
		"Particular"
	],
	[
		"https://sp.olx.com.br/vale-do-paraiba-e-litoral-norte/imoveis/aluguel?f=c",
		"12",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/baixada-santista-e-litoral-sul/imoveis/aluguel?f=p",
		"13",
		"Particular"
	],
	[
		"https://sp.olx.com.br/baixada-santista-e-litoral-sul/imoveis/aluguel?f=c",
		"13",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/regiao-de-bauru-e-marilia/imoveis/aluguel?f=p",
		"14",
		"Particular"
	],
	[
		"https://sp.olx.com.br/regiao-de-bauru-e-marilia/imoveis/aluguel?f=c",
		"14",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/regiao-de-sorocaba/imoveis/aluguel?f=p",
		"15",
		"Particular"
	],
	[
		"https://sp.olx.com.br/regiao-de-sorocaba/imoveis/aluguel?f=c",
		"15",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/regiao-de-ribeirao-preto/imoveis/aluguel?f=p",
		"16",
		"Particular"
	],
	[
		"https://sp.olx.com.br/regiao-de-ribeirao-preto/imoveis/aluguel?f=c",
		"16",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/regiao-de-sao-jose-do-rio-preto/imoveis/aluguel?f=p",
		"17",
		"Particular"
	],
	[
		"https://sp.olx.com.br/regiao-de-sao-jose-do-rio-preto/imoveis/aluguel?f=c",
		"17",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/regiao-de-presidente-prudente/imoveis/aluguel?f=p",
		"18",
		"Particular"
	],
	[
		"https://sp.olx.com.br/regiao-de-presidente-prudente/imoveis/aluguel?f=c",
		"18",
		"Profissional"
	],
	[
		"https://sp.olx.com.br/grande-campinas/imoveis/aluguel?f=p",
		"19",
		"Particular"
	],
	[
		"https://sp.olx.com.br/grande-campinas/imoveis/aluguel?f=c",
		"19",
		"Profissional"
	],
	
]	

# Inicializa o array multidimensional que 
# será usado na criação da planilha
data = []
data.append(['DDD', 'Modalidade', 'Título', 'Preço', 'Área', 'Tipo', 'Url'])

# Itera sobre cada DDD
for itemPorDDD in links:

	# Resgata a página
	page = requests.get(itemPorDDD[0])
	content = page.text

	# Inicializa o BS4 com o conteúdo da página
	soup = BeautifulSoup(content, 'html.parser')

	# Resgata todos os imóveis da página
	lourdes = soup.find(id='main-ad-list').find_all('li', 'item')

	# Extrai os dados de cada imóvel
	for lu in lourdes:
		item = []
		if (not type(lu) is None):
		
			# DDD
			ddd = itemPorDDD[1]
			item.append(ddd)
			
			# Modalidade de venda
			modalidade = itemPorDDD[2]
			item.append(modalidade)
		
			# Título
			titulo = lu.find(class_="OLXad-list-title")
			if titulo is not None:
				titulo = titulo.text.strip()
			else:
				titulo = ""
				
			item.append(titulo)
			
			# Preço
			preco = lu.find(class_="OLXad-list-price")
			if preco is not None:
				preco = preco.text
				preco = remove_prefix(preco, " ")
				preco = remove_prefix(preco, "R$ ")
				preco = preco.replace(".","")
				preco = preco.replace(",",".")
				preco = float(preco)
			else:
				preco = 0.0
				
			item.append(preco)
				
			# Área
			area = lu.find(class_="text detail-specific")
			if area is not None:
				area = area.text
				area = re.findall(r"(\d+) m²", area)
				if len(area) > 0:
					area = area[0]
				else:
					area = 0
			else:
				area = 0
				
			item.append(area)
				
			# Tipo
			tipo = lu.find(class_="text detail-category")
			if tipo is not None:
				for child in tipo.find_all("span"):
					child.decompose()
				tipo = tipo.text.strip()
			else:
				tipo = ""
				
			item.append(tipo)
			
			# URL
			url = lu.find(class_="OLXad-list-link")
			if url is not None:
				url = url['href']
			else:
				url = ""
				
			item.append(url)
			
			# Forma de venda
			formaVenda = lu.find(class_="text detail-specific")
			if formaVenda is not None:
				formaVenda = formaVenda.text
				ehVenda = re.findall(r"À venda", formaVenda)
				ehAluguel = re.findall(r"Para alugar", formaVenda)
				if len(ehVenda) > 0:
					formaVenda = "Venda"
				else:
					if len(ehAluguel) > 0:
						formaVenda = "Aluguel"
					
			else:
				formaVenda = ""

			item.append(formaVenda)

			# Acessa a página interna do imóvel para raspar mais infos
				# Resgata a página
				#page2 = requests.get(url)
				#content2 = page2.text

				# Inicializa o BS4 com o conteúdo da página
				#soup2 = BeautifulSoup(content2, 'html.parser')

				# Resgata todos os imóveis da página
				#lourdes = soup2.find(id='main-ad-list').find_all('li', 'item')
					
				# Print em console das infos organizadas
				#if debug:
				#	print(titulo+" - "+ddd+" - "+modalidade+"\n")
				#	print(url+"\n")
				#	print(str(area)+" - "+tipo+"\n")
				#	print(str(preco)+"\n------------\n")

			# Insere o imóvel processado no conjunto
			data.append(item)
	
	
# Inicializa conexão com o MySQL
mydb = mysql.connector.connect(
  host="172.18.0.2",
  user="test",
  passwd="password",
  database="lourdescraping"
)

mycursor = mydb.cursor()
# sql para criar tabela
mycursor.execute("CREATE TABLE "+ tablename +" (ddd INT(10), modalidade VARCHAR(255), titulo VARCHAR(255), preco INT(10), area INT(10), tipo VARCHAR(255), url VARCHAR(255), formaVenda VARCHAR(255))")

# sql para inserir dados ao banco
sql = "INSERT INTO "+ tablename +" (ddd, modalidade, titulo, preco, area, tipo, url, formaVenda) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"

# Pega todos os elementos exceto o primeiro que é o header
rows = data[1:]
# Percorre as linhas executando o sql de inserção
for row in rows:
	mycursor.execute(sql, row)

mydb.commit()
			

# Inicializa a pasta de planilhas				
book = Workbook()

# Seleciona a primeira planilha
sheet = book.active

# Insere as linhas
for row in data:
    sheet.append(row)

# Salva a planilha
book.save('./../dataframing/lourdes.xlsx')
