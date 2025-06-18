## DVWA WAF Evasion - Laboratório de Bypass Cloudflare

> **Projeto desenvolvido por JamesCode (Tiago Santana Ferreira) para a comunidade de segurança ofensiva**

---

## 🎯 Objetivo

Criar um ambiente controlado com o **DVWA (Damn Vulnerable Web Application)** exposto através da **Cloudflare**, com o WAF (Web Application Firewall) ativado, permitindo testar **técnicas de evasão e bypass de WAF**.

> ⚠️ **Atenção:** Este projeto é apenas para fins educacionais e de pesquisa.  
> Nunca realize ataques em ambientes que você não tem autorização.

---

## 📋 Requisitos

- Uma máquina Linux (exemplo: Kali Linux)
- Docker + Docker Compose
- Cloudflared
- Uma conta gratuita na [Cloudflare](https://dash.cloudflare.com)
- Um domínio próprio (recomendado: .shop, .online ou outro domínio barato)

---

## 🐳 Instalação do Docker e Docker Compose

```bash
sudo apt update
sudo apt install docker.io docker-compose -y
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER
newgrp docker
```

---

## 🧱 Subindo o DVWA com Docker Compose

## 📦 Instalação e Inicialização do DVWA

```bash
cd ~/Downloads
git clone <url-do-repositório>
cd dvwa-waf-evasion-cloudflare-main
docker-compose up -d
docker ps
```
## 💡 Configuração do arquivo `config.inc.php` para o DVWA

 Você precisa colocar o arquivo `config.inc.php` dentro da pasta `config` do seu projeto local (no host), que será mapeada automaticamente para o container DVWA.

### 🛠️ Passos Concretos para Resolver:

No seu terminal (como usuário normal, não root):

```bash
cd ~/Downloads/dvwa-waf-evasion-cloudflare-main
```

Crie a pasta `config` (se não existir):

```bash
mkdir -p config
```

Crie o arquivo `config.inc.php` manualmente com o seguinte conteúdo:

```bash
cat > config/config.inc.php << 'EOF'
<?php
$DBMS = 'MySQL';
$_DVWA = array();
$_DVWA['db_server'] = 'mysql';       # Nome do serviço no docker-compose
$_DVWA['db_user'] = 'app';           # Usuário definido no compose
$_DVWA['db_password'] = 'password';  # Senha definida no compose
$_DVWA['db_database'] = 'dvwa';
$_DVWA['default_security_level'] = 'low';
?>
EOF
```
![Image](https://github.com/user-attachments/assets/a316273c-ef83-41a0-be5d-417e9180c9ea)

## 🔐 Login no Cloudflare via Cloudflared

### Autenticação no Cloudflare

```bash
cloudflared tunnel login
```

✅ Isso abrirá um link no navegador para autenticação.

Após o login, será gerado o seguinte arquivo:

```bash
/root/.cloudflared/cert.pem
```

---

## 🚇 Criando e Configurando o Tunnel

## 📌 Criar o Tunnel

```bash
cloudflared tunnel create labdvwa-shop-tunnel
```

✅ O comando irá gerar um JSON de credenciais, exemplo:

```bash
/root/.cloudflared/xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx.json
```

---

### 📝 Criar o arquivo de configuração `config.yml`

Exemplo básico:

```yaml
tunnel: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
credentials-file: /root/.cloudflared/xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx.json

ingress:
  - hostname: www.seudominio.com
    service: http://localhost:8080
  - service: http_status:404
```

---

### ▶️ Rodando o Tunnel

```bash
cloudflared tunnel run labdvwa-shop-tunnel
```

✅ Se tudo estiver correto, o túnel iniciará e ficará escutando as requisições.

---

## 🌐 Configuração do DNS na Cloudflare

Acesse o painel da Cloudflare.

Vá em: **DNS → Registros**

Adicione um **CNAME** com as seguintes informações:

| Tipo  | Nome | Conteúdo                                         | Proxy    |
|-------|-------|------------------------------------------------|----------|
| CNAME | www   | xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx.cfargotunnel.com | Ativado |

⚠️ **Importante:** Substitua o conteúdo pelo hostname real gerado no seu Tunnel.

---


# ✅ Teste de acesso

No navegador:

```bash
https://www.seudominio.com
```

✅ Se tudo estiver correto, o **DVWA** vai carregar, passando pelo **WAF da Cloudflare**.

---

![Image](https://github.com/user-attachments/assets/e0068814-a235-40d2-9739-05d90105c965)

## 🚩 Testes de Bypass (Exemplos)

Após o ambiente estar funcionando, você pode realizar os seguintes testes de evasão:

- ✅ **SQL Injection**
- ✅ **Cross-Site Scripting (XSS)**
- ✅ **Local File Inclusion (LFI)**
- ✅ **Command Injection**
- ✅ **Path Traversal**

> Lembre-se de alterar o nível de segurança do DVWA (**low**, **medium**, **high**) conforme seu objetivo de teste.

---

## ⚠️ Aviso sobre o domínio

Foi comprado um domínio `.shop` por apenas **R$ 3,00**.

❌ **Não é recomendado expor um domínio público para uso coletivo neste tipo de laboratório.**

👉 **Recomendação:** Que cada pessoa compre seu próprio domínio para evitar:

- Abusos
- Bloqueios de IP
- Limitações de requisição
- Problemas com a própria Cloudflare

---

## ✅ Objetivo final

Avaliar como o **WAF da Cloudflare** reage a **payloads ofensivos reais**.

Este lab **simula um ambiente de produção**, com um serviço protegido pela **Cloudflare**, permitindo testar na prática a eficácia de técnicas de evasão.

---

## ✅ Contribuições

Se quiser sugerir melhorias, enviar novos payloads de bypass ou compartilhar resultados dos seus testes:

- Faça um **Pull Request**
- Ou abra uma **Issue**

---

## ✅ Disclaimer Legal

Este projeto é **apenas para fins de estudo e pesquisa ética**.

**Não nos responsabilizamos por qualquer uso indevido deste material.**

⚠️ Utilize com responsabilidade e **apenas em ambientes que você tem autorização**.

---

## ✅ Autor

**JamesCode (Tiago Santana Ferreira)**  
Fullstack Developer | Pentester | Offensive Security Researcher
