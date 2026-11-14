#!/usr/bin/env python3
"""Gera backend/seed.sql com dados de demonstração para o ETEConnect.

Uso:  python3 docker/seed/generate_seed.py
Todas as contas usam a senha: Etec@2025
"""
import random
from datetime import datetime, timedelta
from pathlib import Path

random.seed(42)
ROOT = Path(__file__).resolve().parents[2]
OUT = ROOT / "backend" / "seed.sql"

# bcrypt de "Etec@2025"
PWD = "$2y$10$MIRxZoqKh//YojERuFFjAeonTQ14gNfiV31fOS1PEowcoHERKlg1i"
NOW = datetime(2026, 11, 13, 20, 0, 0)

# campus 2 = Etec Albert Einstein (servidor 3) | campus 28 = Parque da Juventude (servidor 29)
MAIN_CAMPUS, MAIN_SERVER = 2, 3
SEC_CAMPUS, SEC_SERVER = 28, 29
GERAL = 1

# (nome, email, matricula, nascimento, campus, cursos, telefone)
USERS = [
    ("Ana Beatriz Souza", "aluno@etec.sp.gov.br", "20231234501", "2008-03-14", MAIN_CAMPUS, [29], "(11) 98765-4321"),
    ("Prof. Ricardo Almeida", "professor@etec.sp.gov.br", "482913", "1984-07-22", MAIN_CAMPUS, [29, 56], "(11) 99876-1122"),
    ("Lucas Ferreira", "lucas.ferreira@etec.sp.gov.br", "20231234502", "2007-11-02", MAIN_CAMPUS, [29], "(11) 97654-3210"),
    ("Mariana Costa", "mariana.costa@etec.sp.gov.br", "20231234503", "2008-01-30", MAIN_CAMPUS, [32], "(11) 96543-2109"),
    ("Gabriel Santos", "gabriel.santos@etec.sp.gov.br", "20231234504", "2007-06-18", MAIN_CAMPUS, [56], "(11) 95432-1098"),
    ("Júlia Oliveira", "julia.oliveira@etec.sp.gov.br", "20231234505", "2008-09-09", MAIN_CAMPUS, [29], "(11) 94321-0987"),
    ("Pedro Henrique Lima", "pedro.lima@etec.sp.gov.br", "20231234506", "2007-04-25", MAIN_CAMPUS, [1], "(11) 93210-9876"),
    ("Profª. Camila Rocha", "camila.rocha@etec.sp.gov.br", "573820", "1989-02-11", MAIN_CAMPUS, [32, 1], "(11) 92109-8765"),
    ("Rafael Martins", "rafael.martins@etec.sp.gov.br", "20231234507", "2008-12-05", MAIN_CAMPUS, [29], "(11) 91098-7654"),
    ("Beatriz Nunes", "beatriz.nunes@etec.sp.gov.br", "20231234508", "2007-08-14", MAIN_CAMPUS, [56], "(11) 90987-6543"),
    ("Thiago Ribeiro", "thiago.ribeiro@etec.sp.gov.br", "20221234509", "2006-10-27", SEC_CAMPUS, [29], "(11) 98877-6655"),
    ("Larissa Mendes", "larissa.mendes@etec.sp.gov.br", "20221234510", "2007-05-03", SEC_CAMPUS, [29], "(11) 97766-5544"),
    ("Prof. Eduardo Carvalho", "eduardo.carvalho@etec.sp.gov.br", "619204", "1979-12-19", SEC_CAMPUS, [29], "(11) 96655-4433"),
    ("Isabela Freitas", "isabela.freitas@etec.sp.gov.br", "20231234511", "2008-07-07", MAIN_CAMPUS, [29], "(11) 95544-3322"),
    ("Matheus Araújo", "matheus.araujo@etec.sp.gov.br", "20231234512", "2007-02-21", MAIN_CAMPUS, [32], "(11) 94433-2211"),
    ("Profª. Fernanda Dias", "fernanda.dias@etec.sp.gov.br", "740158", "1986-04-08", SEC_CAMPUS, [29], "(11) 93322-1100"),
]
ADDRESS = "Rua das Flores, 120, São Paulo, SP, 03000-000"


def q(v):
    if v is None:
        return "NULL"
    if isinstance(v, (int, float)):
        return str(v)
    if isinstance(v, datetime):
        return "'" + v.strftime("%Y-%m-%d %H:%M:%S") + "'"
    return "'" + str(v).replace("\\", "\\\\").replace("'", "''") + "'"


def ago(**kw):
    return NOW - timedelta(**kw)


lines = ["-- Dados de demonstração gerados por docker/seed/generate_seed.py", "USE tcc;", "SET NAMES utf8mb4;", ""]

# ---------- usuários ----------
for i, (name, email, reg, bday, campus, courses, phone) in enumerate(USERS, start=1):
    role = "professor" if len(reg) == 6 else "estudante"
    created = ago(days=200 - i * 6)
    lines.append(
        "INSERT INTO user (id, name, email, phone, address, registration, birthday, role, created_at, password_hash) VALUES "
        f"({i}, {q(name)}, {q(email)}, {q(phone)}, {q(ADDRESS)}, {q(reg)}, {q(bday)}, {q(role)}, {q(created)}, {q(PWD)});"
    )
lines.append("")
for i, u in enumerate(USERS, start=1):
    lines.append(f"INSERT INTO user_campus (user_id, campus_id) VALUES ({i}, {u[4]});")
    for c in u[5]:
        lines.append(f"INSERT INTO user_course (user_id, course_id) VALUES ({i}, {c});")
# professores também participam do segundo campus para demonstrar múltiplos servidores
lines.append(f"INSERT INTO user_campus (user_id, campus_id) VALUES (2, {SEC_CAMPUS});")
lines.append("")

# ---------- posts ----------
# (autor, servidor, texto, horas atrás, [imagens])
POSTS = [
    (2, MAIN_SERVER, "Pessoal do 3º DS: a entrega parcial do TCC foi adiada para o dia 28. Aproveitem para revisar a documentação e o diagrama de casos de uso. Qualquer dúvida, me chamem aqui ou nas mensagens!", 3, []),
    (8, MAIN_SERVER, "Que orgulho da turma de Design Gráfico! Os cartazes da Semana da Consciência Negra ficaram incríveis e já estão expostos no corredor do bloco B. 🎨", 7, ["seed/post1.jpg", "seed/post2.jpg"]),
    (2, MAIN_SERVER, "Lembrete: amanhã teremos aula prática de banco de dados no laboratório 4. Tragam o script DDL do projeto de vocês, vamos normalizar juntos.", 20, []),
    (8, MAIN_SERVER, "Abertas as inscrições para a oficina de UI/UX no sábado. Vagas limitadas! Inscrevam-se pela aba Eventos.", 30, ["seed/post3.jpg"]),
    (2, MAIN_SERVER, "Parabéns ao grupo do EteConnect pela apresentação na banca prévia. Projeto muito bem estruturado, com front, API e banco funcionando de ponta a ponta. 👏", 52, ["seed/post4.jpg"]),
    (8, MAIN_SERVER, "Biblioteca recebeu novos livros de tipografia e design de interfaces. Corram para reservar!", 75, []),
    (2, MAIN_SERVER, "Material da aula de hoje sobre JWT e refresh tokens já está disponível. Revisem a diferença entre autenticação e autorização antes da prova.", 98, []),
    (8, MAIN_SERVER, "Visita técnica à agência de design confirmada para o dia 05/12. Levem a autorização assinada pelos responsáveis.", 130, ["seed/post5.jpg"]),
    (13, SEC_SERVER, "Bem-vindos ao servidor da Etec Parque da Juventude! Usem este espaço para dúvidas sobre as disciplinas de programação.", 10, []),
    (16, SEC_SERVER, "Hackathon interno confirmado: 48h, temas ligados a sustentabilidade. Montem seus grupos de até 4 pessoas!", 40, ["seed/post6.jpg"]),
    (13, SEC_SERVER, "Resultados do simulado de lógica de programação já foram lançados. Média da turma: 7,8. Mandaram bem!", 90, []),
    (2, GERAL, "Olá a todas as Etecs! Este é o servidor geral do ETEConnect — compartilhem eventos abertos, oportunidades de estágio e projetos.", 5, []),
    (16, GERAL, "Feira de Profissões do Centro Paula Souza acontece mês que vem. Ótima oportunidade para quem está decidindo a graduação.", 26, ["seed/post2.jpg"]),
    (8, GERAL, "Dica de estudo: o Figma tem plano gratuito para estudantes. Vale muito a pena para prototipar o front do TCC.", 60, []),
    (13, GERAL, "Vagas de estágio em desenvolvimento web na zona leste — mandem o currículo para o e-mail da coordenação.", 110, []),
]
for pid, (author, server, text, hours, imgs) in enumerate(POSTS, start=1):
    lines.append(
        f"INSERT INTO post (id, id_author, server_id, content, created_at) VALUES ({pid}, {author}, {server}, {q(text)}, {q(ago(hours=hours))});"
    )
    for order, img in enumerate(imgs):
        lines.append(
            f"INSERT INTO post_media (post_id, media_url, media_type, media_order) VALUES ({pid}, {q('uploads/mediaPost/' + img)}, 'image', {order});"
        )
lines.append("")

# ---------- comentários ----------
COMMENTS = [
    (1, 1, None, "Ufa! Professor, a documentação pode ser entregue em PDF?", 2.5),
    (1, 2, 1, "Pode sim, Ana. Só não esqueçam a capa padrão da Etec.", 2.2),
    (1, 3, None, "Valeu prof, vai dar tempo de terminar o diagrama de classes.", 2),
    (2, 4, None, "Obrigada professora!! Foi muito trabalho mas valeu a pena 💛", 6),
    (2, 15, 4, "Ficou top demais o seu, Mari!", 5.5),
    (3, 6, None, "Precisa trazer impresso ou pode ser no pendrive?", 18),
    (3, 2, 6, "Pendrive ou GitHub, Júlia.", 17),
    (5, 1, None, "Obrigada professor! O grupo todo agradece 🙌", 50),
    (5, 9, None, "Arrasaram demais!", 49),
    (5, 14, None, "Quero ver o deploy final 👀", 48),
    (4, 5, None, "Já me inscrevi! Vai ter certificado?", 28),
    (4, 8, 11, "Vai sim, Gabriel. 4 horas complementares.", 27),
    (9, 11, None, "Professor, as listas de exercícios vão ficar aqui também?", 9),
    (10, 12, None, "Já temos grupo formado! Bora 🚀", 38),
    (12, 3, None, "Que legal ter um espaço com todas as Etecs!", 4),
]
for cid, (post, author, parent, text, hours) in enumerate(COMMENTS, start=1):
    lines.append(
        f"INSERT INTO comment (id, id_post, id_author, id_parent_comment, content, created_at) VALUES ({cid}, {post}, {author}, {q(parent)}, {q(text)}, {q(ago(hours=hours))});"
    )
lines.append("")

# ---------- curtidas ----------
likes = set()
for pid in range(1, len(POSTS) + 1):
    for uid in random.sample(range(1, len(USERS) + 1), random.randint(3, 12)):
        likes.add((uid, "post", pid))
for cid in range(1, len(COMMENTS) + 1):
    for uid in random.sample(range(1, len(USERS) + 1), random.randint(0, 5)):
        likes.add((uid, "comment", cid))
for uid, ctype, cid in sorted(likes):
    lines.append(f"INSERT INTO likes (user_id, content_type, content_id) VALUES ({uid}, '{ctype}', {cid});")
lines.append("")

# ---------- seguidores ----------
follows = set()
for a in range(1, len(USERS) + 1):
    for b in random.sample(range(1, len(USERS) + 1), random.randint(3, 8)):
        if a != b:
            follows.add((a, b))
for a in (1, 3, 4, 5, 6, 9, 14):
    follows.add((a, 2))
follows.add((2, 1))
for a, b in sorted(follows):
    lines.append(f"INSERT INTO follower (follower_id, followed_id) VALUES ({a}, {b});")
lines.append("")

# ---------- mensagens ----------
CONVERSAS = [
    (1, 2, [
        (1, "Oi professor, posso tirar uma dúvida sobre o TCC?", 26),
        (2, "Claro, Ana! Pode mandar.", 25.8),
        (1, "A gente pode usar MySQL em vez de PostgreSQL no projeto?", 25.7),
        (2, "Pode sim, o importante é justificar a escolha na documentação.", 25.5),
        (1, "Perfeito, obrigada! 😊", 25.4),
        (2, "Lembra de mandar o link do repositório até sexta.", 1.5),
    ]),
    (1, 3, [
        (3, "Ana, você já subiu a parte do login no GitHub?", 5),
        (1, "Subi agora! Dá um pull aí", 4.8),
        (3, "Show, vou testar aqui", 4.7),
        (3, "Funcionou 🔥", 0.5),
    ]),
    (1, 4, [
        (4, "Fiz uns mockups novos pro feed, quer ver?", 30),
        (1, "Quero muito! Me manda", 29),
        (4, "Te mando amanhã no intervalo", 3),
    ]),
    (1, 6, [
        (6, "Vai ter grupo de estudo pra prova de BD?", 50),
        (1, "Vai sim, quinta depois da aula na biblioteca", 49),
    ]),
    (2, 8, [
        (8, "Ricardo, consegue me ajudar com a banca do dia 28?", 12),
        (2, "Consigo sim, Camila. Fico com o período da tarde.", 11),
    ]),
]
for a, b, msgs in CONVERSAS:
    last = len(msgs) - 1
    for k, (sender, text, hours) in enumerate(msgs):
        receiver = b if sender == a else a
        read = "FALSE" if (k == last and hours < 6) else "TRUE"
        lines.append(
            f"INSERT INTO message (sender_id, receiver_id, content, created_at, is_read) VALUES ({sender}, {receiver}, {q(text)}, {q(ago(hours=hours))}, {read});"
        )
lines.append("")

# ---------- eventos ----------
EVENTS = [
    (MAIN_SERVER, "Oficina de UI/UX com Figma", "Aprenda a prototipar interfaces do zero: wireframes, componentes e protótipos navegáveis. Traga seu notebook.", 4, "09:00:00", "Laboratório 4 — Bloco B", 30),
    (MAIN_SERVER, "Banca de TCC — 3º DS", "Apresentação dos projetos de conclusão de curso da turma de Desenvolvimento de Sistemas. Aberto à comunidade.", 15, "13:30:00", "Auditório principal", 120),
    (MAIN_SERVER, "Semana da Consciência Negra", "Rodas de conversa, exposição de cartazes e apresentações culturais organizadas pelos alunos.", 7, "10:00:00", "Pátio central", 300),
    (MAIN_SERVER, "Palestra: Carreira em Tecnologia", "Ex-alunos contam como entraram no mercado de trabalho e respondem dúvidas sobre estágio.", 22, "19:00:00", "Auditório principal", 80),
    (SEC_SERVER, "Hackathon Sustentável 48h", "Maratona de programação com foco em soluções para sustentabilidade urbana. Prêmios para os três primeiros lugares.", 10, "08:00:00", "Ginásio coberto", 60),
    (SEC_SERVER, "Workshop de Git e GitHub", "Do primeiro commit ao pull request: fluxo de trabalho em equipe.", 3, "14:00:00", "Laboratório 2", 25),
    (GERAL, "Feira de Profissões CPS", "Feira aberta a todas as Etecs com estandes de universidades e empresas parceiras.", 30, "09:00:00", "Centro de Convenções — São Paulo", 1000),
]
for eid, (server, title, desc, days, time, loc, cap) in enumerate(EVENTS, start=1):
    date = (NOW + timedelta(days=days)).strftime("%Y-%m-%d")
    lines.append(
        f"INSERT INTO events (id, server_id, title, description, date, time, location, capacity) VALUES ({eid}, {server}, {q(title)}, {q(desc)}, {q(date)}, {q(time)}, {q(loc)}, {cap});"
    )
parts = set()
for eid in range(1, len(EVENTS) + 1):
    for uid in random.sample(range(1, len(USERS) + 1), random.randint(3, 10)):
        parts.add((eid, uid))
parts.add((1, 1))
parts.add((2, 1))
for eid, uid in sorted(parts):
    lines.append(f"INSERT INTO event_participants (event_id, user_id) VALUES ({eid}, {uid});")
lines.append("")

# ---------- avisos ----------
NOTICES = [
    (MAIN_SERVER, "Rematrícula aberta", "A rematrícula para o próximo semestre vai até o dia 30. Procure a secretaria com RG e comprovante de residência.", "importante", 2),
    (MAIN_SERVER, "Banca de TCC — cronograma", "O cronograma das bancas foi publicado no mural do bloco A e na aba Eventos.", "evento", 20),
    (MAIN_SERVER, "Laboratório 3 em manutenção", "O laboratório 3 ficará fechado até sexta-feira para troca dos computadores.", "importante", 48),
    (MAIN_SERVER, "Oficina de UI/UX", "Inscrições abertas para a oficina de Figma no sábado pela manhã.", "evento", 72),
    (MAIN_SERVER, "Uso obrigatório do crachá", "A partir de segunda-feira o acesso à escola será feito somente com o crachá de estudante.", "importante", 120),
    (SEC_SERVER, "Hackathon — inscrições", "Inscrições do hackathon pelo formulário da coordenação até quarta.", "evento", 15),
    (SEC_SERVER, "Reposição de aula", "Haverá reposição da aula de PAM no sábado, das 8h às 12h.", "importante", 60),
    (GERAL, "Bem-vindo ao ETEConnect", "Este é o canal geral, compartilhado por todas as Etecs. Seja respeitoso e ajude os colegas!", "importante", 200),
]
for server, title, desc, ntype, hours in NOTICES:
    lines.append(
        f"INSERT INTO notice (server_id, title, description, type, created_at) VALUES ({server}, {q(title)}, {q(desc)}, {q(ntype)}, {q(ago(hours=hours))});"
    )
lines.append("")

# ---------- projetos de TCC ----------
PROJECTS = [
    ("ETEConnect", "Rede social acadêmica que conecta alunos e professores das Etecs, com feed por unidade, avisos, eventos, mensagens e vitrine de TCCs.", 29, MAIN_CAMPUS, [1, 3, 6], 40),
    ("EcoTrack", "Aplicativo para monitorar o consumo de água e energia da escola usando sensores IoT e painéis em tempo real.", 29, MAIN_CAMPUS, [9, 14], 80),
    ("Identidade Visual Etec 2026", "Rebranding da comunicação visual da unidade: logotipo, sinalização e templates para redes sociais.", 32, MAIN_CAMPUS, [4, 15], 120),
    ("LojaFácil", "E-commerce para pequenos comerciantes do bairro com gestão de estoque simplificada.", 56, MAIN_CAMPUS, [5, 10], 160),
    ("FinanJovem", "Plataforma de educação financeira para adolescentes com trilhas gamificadas.", 1, MAIN_CAMPUS, [7], 200),
    ("Horta Inteligente", "Sistema de irrigação automatizado com Arduino e app de acompanhamento.", 29, SEC_CAMPUS, [11, 12], 60),
]
for pid, (title, desc, course, campus, members, hours) in enumerate(PROJECTS, start=1):
    lines.append(
        f"INSERT INTO tcc_project (id, title, description, course_id, campus_id, created_at) VALUES ({pid}, {q(title)}, {q(desc)}, {course}, {campus}, {q(ago(hours=hours))});"
    )
    for m in members:
        lines.append(f"INSERT INTO tcc_project_members (project_id, user_id) VALUES ({pid}, {m});")
plikes = set()
for pid in range(1, len(PROJECTS) + 1):
    for uid in random.sample(range(1, len(USERS) + 1), random.randint(2, 11)):
        plikes.add((uid, pid))
for uid, pid in sorted(plikes):
    lines.append(f"INSERT INTO likes (user_id, content_type, content_id) VALUES ({uid}, 'tcc_project', {pid});")

OUT.write_text("\n".join(lines) + "\n", encoding="utf-8")
print(f"seed escrito em {OUT} ({len(lines)} linhas)")
