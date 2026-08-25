# Guía de Despliegue — Oracle Always Free + Dominio Gratis

Proyecto: Iglesia El Cordero de Dios en el Perú
Stack: Laravel 13 + SQLite + imágenes locales + Docker

---

## FASE 0 — Subir los cambios a GitHub (desde tu PC)

```powershell
git add -A
git commit -m "Version autocontenida: SQLite + imagenes locales + docker-compose"
git push origin main
```

> Si la rama es `master`, usa `git push origin master`.

---

## FASE 1 — Crear cuenta Oracle Cloud (gratis para siempre)

1. Entra a: **https://www.oracle.com/cloud/free/**
2. Clic en **"Start for free"** (Empieza gratis).
3. Completa: país, nombre, correo real → verifica el correo.
4. Completa tus datos y **tarjeta de débito/crédito** (solo verifican identidad, NO cobran).
5. **Región del hogar (importante, no se puede cambiar):**
   Elige `US East (Ashburn)` — suele tener más capacidad disponible y buena latencia para Perú.
6. La activación puede tardar de minutos a unas horas. Te llegará un correo "Get Started Now".

---

## FASE 2 — Crear el servidor (VM)

1. Ya dentro de la consola (cloud.oracle.com), menú **☰** → **Compute → Instances → Create Instance**.
2. Configura:
   - **Name:** `iglesia`
   - **Image:** `Ubuntu 24.04` (clic en "Change image" si viene Oracle Linux)
   - **Shape:** `VM.Standard.A1.Flex` (Ampere) → **2 OCPU / 12 GB RAM** (es lo gratis)
   > Si dice "out of capacity": cambia availability domain o intenta más tarde. Es el error más común.
3. **SSH keys:** selecciona *"Generate a key pair"* → **descarga AMBAS claves** (la privada `.key` es OBLIGATORIA, guárdala bien).
4. Clic **Create** → espera 1 minuto → **copia la IP pública** que aparece arriba.

---

## FASE 3 — Abrir los puertos (hay 2 firewalls)

### 3.1 Firewall de Oracle (consola web)
1. Menú **☰** → **Networking → Virtual Cloud Networks** → entra a la VCN de tu instancia.
2. **Security Lists → Default Security List → Add Ingress Rules.**
3. Agrega 2 reglas (una por cada puerto):

| Source CIDR | Protocol | Destination Port |
|---|---|---|
| 0.0.0.0/0 | TCP | 80 |
| 0.0.0.0/0 | TCP | 443 |

### 3.2 Firewall interno de Ubuntu
Conéctate por SSH desde PowerShell (ajusta la ruta de tu clave):

```powershell
ssh -i "C:\ruta\a\tu-clave.key" ubuntu@TU_IP_PUBLICA
```

Dentro del servidor ejecuta:

```bash
sudo iptables -I INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -I INPUT -p tcp --dport 443 -j ACCEPT
sudo apt install -y iptables-persistent
sudo netfilter-persistent save
```

---

## FASE 4 — Instalar Docker en el servidor

```bash
sudo apt update && sudo apt upgrade -y
curl -fsSL https://get.docker.com | sudo sh
sudo usermod -aG docker $USER
exit
```

Vuelve a conectarte por SSH y prueba:

```bash
docker --version
```

---

## FASE 5 — Desplegar el proyecto

```bash
git clone https://github.com/Jeremyvc2202/Iglesia.git
cd Iglesia
docker compose up -d --build
```

La primera vez tarda 5–10 minutos (compila frontend + instala PHP).

Verifica: abre `http://TU_IP_PUBLICA` en el navegador.
Panel admin: `http://TU_IP_PUBLICA/acceder`

Comandos útiles:

```bash
docker compose logs -f        # ver errores
docker compose restart        # reiniciar
docker compose down           # apagar
docker compose up -d --build  # actualizar tras git pull
```

---

## FASE 6 — Dominio GRATIS (DigitalPlat)

1. Entra a: **https://dash.domain.digitalplat.org/**
2. Crea cuenta (verifica correo).
3. **Register Domain** → elige extensión `.dpdns.org` → busca un nombre, ej: `iglesia-elcordero.dpdns.org`.
4. Te pedirá **nameservers**: puedes dejarlo y cambiarlo en el paso siguiente.

---

## FASE 7 — HTTPS con Cloudflare (gratis)

1. Crea cuenta en: **https://dash.cloudflare.com/sign-up**
2. **Add a site** → escribe tu dominio (`iglesia-elcordero.dpdns.org`) → plan **Free**.
3. Cloudflare te da **2 nameservers** (ej: `ana.ns.cloudflare.com`, `bob.ns.cloudflare.com`). Cópialos.
4. Vuelve a DigitalPlat → **Domain Management** → tu dominio → edita los Nameservers con los de Cloudflare.
5. Espera la activación en Cloudflare (minutos a horas, llega un correo).
6. En Cloudflare → **DNS → Records → Add record:**

| Type | Name | Content | Proxy |
|---|---|---|---|
| A | @ | TU_IP_PUBLICA_DE_ORACLE | Activado (nube naranja) |

7. **SSL/TLS → Overview → modo `Flexible`** (funciona al instante).

---

## FASE 8 — Apuntar la app al dominio

En el servidor, edita `docker-compose.yml` y cambia:

```yaml
APP_URL: https://tu-dominio.dpdns.org
```

Aplica el cambio:

```bash
nano docker-compose.yml     # editar (Ctrl+O guardar, Ctrl+X salir)
docker compose up -d
```

Listo: `https://tu-dominio.dpdns.org` 🎉
Admin: `https://tu-dominio.dpdns.org/acceder`

---

## Datos de acceso

- Usuario: `cordero2026@gmail.com`
- Contraseña: se crea con el seeder (`Cordero2026`) — cámbiala cuando quieras.

## Mantenimiento diario

Actualizar la página cuando cambies código en tu PC:

```powershell
# En tu PC
git add -A ; git commit -m "cambios" ; git push
```
```bash
# En el servidor
cd ~/Iglesia && git pull && docker compose up -d --build
```

Hacer respaldo de la base de datos e imágenes:

```bash
docker cp iglesia-web:/var/www/html/database/database.sqlite ./respaldo.sqlite
```
