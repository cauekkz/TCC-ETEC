#!/usr/bin/env python3
from pathlib import Path
from PIL import Image, ImageDraw, ImageFont

OUT = Path(__file__).resolve().parents[2] / "backend" / "uploads" / "mediaPost" / "seed"
OUT.mkdir(parents=True, exist_ok=True)
W, H = 1200, 800
POSTERS = [
    ("Consciência\nNegra", "Exposição de cartazes", "BLOCO B · 20 NOV", (26, 26, 24), (245, 244, 240), (214, 160, 52)),
    ("Cartazes\n3º Design", "Turma de Design Gráfico", "CORREDOR · BLOCO B", (232, 226, 214), (28, 27, 25), (180, 35, 24)),
    ("Oficina\nde UI/UX", "Prototipando no Figma", "SÁBADO · LAB 4 · 9H", (31, 79, 184), (245, 244, 240), (245, 244, 240)),
    ("Banca\nprévia", "Desenvolvimento de Sistemas", "AUDITÓRIO · 13H30", (245, 244, 240), (28, 27, 25), (180, 35, 24)),
    ("Visita\ntécnica", "Agência de design", "05 DEZ · SAÍDA 8H", (30, 122, 76), (245, 244, 240), (245, 244, 240)),
    ("Hackathon\n48h", "Tema: sustentabilidade urbana", "GINÁSIO · INSCRIÇÕES ABERTAS", (180, 35, 24), (245, 244, 240), (245, 244, 240)),
]

def font(size, kind="serif"):
    paths = {
        "serif": ["/usr/share/fonts/google-noto/NotoSerif-Bold.ttf", "/usr/share/fonts/dejavu-serif-fonts/DejaVuSerif-Bold.ttf",
                  "/usr/share/fonts/truetype/dejavu/DejaVuSerif-Bold.ttf"],
        "sans": ["/usr/share/fonts/google-noto/NotoSans-Medium.ttf", "/usr/share/fonts/dejavu-sans-fonts/DejaVuSans.ttf",
                 "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf"],
        "bold": ["/usr/share/fonts/google-noto/NotoSans-Bold.ttf", "/usr/share/fonts/dejavu-sans-fonts/DejaVuSans-Bold.ttf",
                 "/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf"],
    }[kind]
    for p in paths:
        if Path(p).exists():
            return ImageFont.truetype(p, size)
    return ImageFont.load_default()

for i, (title, sub, meta, bg, ink, accent) in enumerate(POSTERS, start=1):
    img = Image.new("RGB", (W, H), bg)
    d = ImageDraw.Draw(img)
    m = 72
    d.text((m, m), "ETEC ALBERT EINSTEIN", font=font(26, "bold"), fill=accent)
    d.line([(m, m + 52), (W - m, m + 52)], fill=ink, width=3)
    d.multiline_text((m, 210), title, font=font(150, "serif"), fill=ink, spacing=0)
    d.line([(m, H - 150), (W - m, H - 150)], fill=ink, width=2)
    d.text((m, H - 120), sub, font=font(38, "sans"), fill=ink)
    tw = d.textlength(meta, font=font(24, "bold"))
    d.text((W - m - tw, H - 110), meta, font=font(24, "bold"), fill=accent)
    img.save(OUT / f"post{i}.jpg", quality=88)
print("cartazes gerados em", OUT)
