#!/usr/bin/env python3
"""Gera imagens ilustrativas para os posts de demonstração (backend/uploads/mediaPost/seed)."""
import random
from pathlib import Path
from PIL import Image, ImageDraw, ImageFilter, ImageFont

OUT = Path(__file__).resolve().parents[2] / "backend" / "uploads" / "mediaPost" / "seed"
OUT.mkdir(parents=True, exist_ok=True)
W, H = 1200, 800
THEMES = [
    ("Semana da Consciência Negra", "Exposição de cartazes · Bloco B", ((180, 30, 40), (240, 150, 40))),
    ("Cartazes 3º Design", "Turma de Design Gráfico", ((60, 20, 90), (220, 60, 110))),
    ("Oficina de UI/UX", "Sábado · Laboratório 4", ((15, 60, 120), (40, 170, 200))),
    ("Banca prévia · EteConnect", "Desenvolvimento de Sistemas", ((150, 20, 30), (40, 40, 60))),
    ("Visita técnica", "Agência de design · 05/12", ((20, 100, 80), (150, 200, 90))),
    ("Hackathon Sustentável", "48h · Parque da Juventude", ((10, 90, 60), (20, 40, 80))),
]

def font(size, bold=False):
    for p in [f"/usr/share/fonts/google-noto/NotoSans-{'Bold' if bold else 'Regular'}.ttf",
              f"/usr/share/fonts/dejavu-sans-fonts/DejaVuSans{'-Bold' if bold else ''}.ttf",
              f"/usr/share/fonts/truetype/dejavu/DejaVuSans{'-Bold' if bold else ''}.ttf"]:
        if Path(p).exists():
            return ImageFont.truetype(p, size)
    return ImageFont.load_default()

for i, (title, sub, (c1, c2)) in enumerate(THEMES, start=1):
    random.seed(i)
    img = Image.new("RGB", (W, H))
    d = ImageDraw.Draw(img)
    for y in range(H):
        t = y / H
        d.line([(0, y), (W, y)], fill=tuple(int(c1[k] * (1 - t) + c2[k] * t) for k in range(3)))
    layer = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    ld = ImageDraw.Draw(layer)
    for _ in range(14):
        r = random.randint(60, 260)
        x, y = random.randint(-100, W), random.randint(-100, H)
        ld.ellipse([x, y, x + r, y + r], fill=(255, 255, 255, random.randint(18, 60)))
    layer = layer.filter(ImageFilter.GaussianBlur(6))
    img = Image.alpha_composite(img.convert("RGBA"), layer)
    d = ImageDraw.Draw(img)
    d.rounded_rectangle([70, H - 290, W - 70, H - 70], radius=28, fill=(0, 0, 0, 90))
    d.text((110, H - 255), title, font=font(64, True), fill="white")
    d.text((112, H - 160), sub, font=font(36), fill=(255, 255, 255, 220))
    img.convert("RGB").save(OUT / f"post{i}.jpg", quality=85)
print("imagens geradas em", OUT)
