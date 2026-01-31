# 🛡️ Guardião DF  
## Auditoria de Dados Sensíveis (LGPD)

O **Guardião DF** é uma ferramenta desenvolvida para **identificar, mascarar e auditar dados sensíveis** em documentos e textos, garantindo a conformidade com a **Lei Geral de Proteção de Dados (LGPD)** no âmbito do **Governo do Distrito Federal (GDF)**.

---

## 🚀 Funcionalidades

- **Extração Multiformato**  
  Leitura de arquivos:
  - PDF
  - DOCX (Word)
  - XLSX (Excel)
  - CSV

- **Scanner Inteligente**  
  Identificação automática de:
  - CPF  
  - CNPJ  
  - RG  
  - Matrículas PPGG  
  - Processos SEI  
  - Endereços do Distrito Federal

- **Mascaramento Automático**  
  Geração de versões protegidas dos documentos, ocultando dados sensíveis.

- **Relatório de Risco**  
  Cálculo de um *Score de Risco* com base na densidade de dados sensíveis encontrados.

---

## 🛠️ Tecnologias e Dependências

O projeto utiliza as seguintes bibliotecas:

- **Smalot/PdfParser**  
  Extração de texto de arquivos PDF digitais.

- **PHPOffice/PhpWord**  
  Leitura e manipulação de documentos `.docx`.

- **Rap2hpoutre/FastExcel**  
  Processamento rápido de planilhas Excel e CSV.

- **Dompdf**  
  Geração de relatórios de auditoria em PDF.
  
---

## 💻 Ambiente de Desenvolvimento (VS Code)
Para editar e evoluir este projeto com a melhor experiência, recomendamos as seguintes linguagens e extensões:

### Linguagens Principais
- **PHP (v8.2+)**    
 A linguagem do motor principal (Laravel).
  
- **Blade**    
 A linguagem de templating do Laravel para as telas do sistema.
  
- **JavaScript (ES6)**    
 Para interações dinâmicas no frontend.
  
- **CSS/Tailwind**    
 Para a estilização da interface

---

## 📥 Instalação e Configuração

### 1️⃣ Clonar o repositório


    git clone https://github.com/seu-usuario/guardiao-df.git
    cd guardiao-df

---

## 📦 Bibliotecas Necessárias (Dependencies)

Para instalar todas as dependências do Guardião DF, execute os seguintes comandos no seu terminal dentro da pasta do projeto:

### 1. Processamento de PDF
Utilizado para extrair camadas de texto de arquivos PDF digitais.

    composer require smalot/pdfparser
    
### 2. Processamento de Word (.docx)

Essencial para ler e percorrer a estrutura de documentos do Microsoft Word.

    composer require phpoffice/phpword

### 3. Processamento de Excel e CSV (.xlsx, .csv)
Uma biblioteca leve e rápida para transformar linhas de planilhas em coleções do Laravel.

    composer require rap2hpoutre/fast-excel

### 4. Geração de Relatórios (PDF Output)
Utilizada para converter suas views Blade nos relatórios finais de auditoria.

    composer require barryvdh/laravel-dompdf

---

## 🛠️ Requisitos Adicionais do Servidor

Além das bibliotecas PHP, o servidor onde o projeto será executado precisa ter estas extensões habilitadas:

- ext-zip: Necessária para a PHPWord abrir os arquivos .docx (que são arquivos XML zipados).
- ext-gd / ext-imagick: Úteis para o processamento de imagens e geração de PDFs.
- ext-mbstring: Para garantir que nomes com acentos (como o "Júlio Cesar") sejam processados corretamente sem erros de codificação.

