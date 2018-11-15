############################################################
# Dockerfile for a Scrapy development environment
# Based on Ubuntu Image
############################################################
 
FROM ubuntu:latest
MAINTAINER NeuralFoundry <neuralfoundry.com>
 
#RUN echo deb http://archive.ubuntu.com/ubuntu precise universe >> /etc/apt/sources.list
RUN apt-get update
 
## Python Family
RUN apt-get install -qy python python-pip python3-pip
 
## Selenium 
RUN apt-get install -qy firefox 
RUN pip install selenium pyvirtualdisplay
  
## Scraping
RUN pip install beautifulsoup4 requests openpyxl pandas
RUN pip3 install beautifulsoup4 requests openpyxl pandas mysql-connector
 
##
# docker run -v ~/Documents/Development:/opt/dev -it scrap-machine  /bin/bash
# tudo que jogar dentro de Development eh acessivel pelo bash do ubuntu em /opt/dev 
#
##