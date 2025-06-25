import pygame
import itertools
import math
import sys

# === Objet 2D ===
class Objet:
    def __init__(self, type_, largeur=0, hauteur=0, rayon=0, base=0):
        self.type = type_
        self.largeur = largeur
        self.hauteur = hauteur
        self.rayon = rayon
        self.base = base
        self.rotations = self.get_rotations()
    
    def get_dimensions(self, angle):
        if self.type == "cercle":
            d = self.rayon * 2
            return (d, d)
        elif self.type == "rectangle":
            if angle % 180 == 0:
                return (self.largeur, self.hauteur)
            else:
                return (self.hauteur, self.largeur)
        elif self.type == "triangle":
            if angle % 180 == 0:
                return (self.base, self.hauteur)
            else:
                return (self.hauteur, self.base)
    
    def get_rotations(self):
        if self.type == "cercle":
            return [0]
        else:
            return [0, 90, 180, 270]

# === Vérifie s’il y a chevauchement ===
def chevauchement(x1, y1, w1, h1, x2, y2, w2, h2):
    return not (x1 + w1 <= x2 or x2 + w2 <= x1 or
                y1 + h1 <= y2 or y2 + h2 <= y1)

def placer_objets(plan_w, plan_h, objets):
    permutations = list(itertools.permutations(objets))

    for perm in permutations:
        placements = []
        if essayer_placement(perm, 0, plan_w, plan_h, placements):
            return placements

    return None

def essayer_placement(objets, index, plan_w, plan_h, placements):
    if index == len(objets):
        return True  

    obj = objets[index]
    for angle in obj.rotations:
        w, h = obj.get_dimensions(angle)
        for x in range(plan_w - int(w) + 1, 5):
            for y in range(plan_h - int(h) + 1, 5):
                collision = False
                for (autre, x2, y2, a2) in placements:
                    w2, h2 = autre.get_dimensions(a2)
                    if chevauchement(x, y, w, h, x2, y2, w2, h2):
                        collision = True
                        break
                if not collision:
                    placements.append((obj, x, y, angle))
                    if essayer_placement(objets, index + 1, plan_w, plan_h, placements):
                        return True
                    placements.pop()
    return False


# === Affichage Pygame ===
def afficher(plan_w, plan_h, placements):
    pygame.init()
    taille_case = 50
    screen = pygame.display.set_mode((plan_w * taille_case, plan_h * taille_case))
    pygame.display.set_caption("2D Bin Packing - Brute Force")

    colors = {
        "rectangle": (200, 0, 0),
        "cercle": (0, 200, 0),
        "triangle": (0, 0, 200)
    }

    screen.fill((255, 255, 255))

    # Grille
    for x in range(plan_w):
        for y in range(plan_h):
            pygame.draw.rect(screen, (220, 220, 220), (x * taille_case, y * taille_case, taille_case, taille_case), 1)

    # Objets
    for (obj, gx, gy, angle) in placements:
        x = gx * taille_case
        y = gy * taille_case
        w, h = obj.get_dimensions(angle)
        w *= taille_case
        h *= taille_case
        color = colors[obj.type]

        if obj.type == "rectangle":
            rect = pygame.Rect(x, y, w, h)
            pygame.draw.rect(screen, color, rect)
        elif obj.type == "cercle":
            pygame.draw.ellipse(screen, color, (x, y, w, h))
        elif obj.type == "triangle":
            if angle % 180 == 0:
                p1 = (x + w / 2, y)
                p2 = (x, y + h)
                p3 = (x + w, y + h)
            else:
                p1 = (x, y + h / 2)
                p2 = (x + w, y)
                p3 = (x + w, y + h)
            pygame.draw.polygon(screen, color, [p1, p2, p3])

    pygame.display.flip()

    # Boucle d’attente
    running = True
    while running:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                running = False
    pygame.quit()
    sys.exit()

# === Main ===
if __name__ == "__main__":
    objets = [
        Objet("rectangle", largeur=1, hauteur=1),
        Objet("cercle", rayon=1),
        Objet("triangle", base=1, hauteur=1),
        Objet("rectangle", largeur=1, hauteur=1),
        Objet("cercle", rayon=1),
        Objet("triangle", base=1, hauteur=1)
    ]
    plan_w, plan_h = 6, 6
    solution = placer_objets(plan_w, plan_h, objets)
    if solution:
        afficher(plan_w, plan_h, solution)
    else:
        print("Aucune solution trouvée.")
