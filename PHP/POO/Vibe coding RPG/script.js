// === Gestion du localStorage ===
const STORAGE_KEY = "rpg-hero-data";

const defaultStats = {
  hp: 100,
  attack: 15,
  defense: 5,
  speed: 6,
  mana: 20,
  critChance: 0.1,
  level: 1,
  xp: 0
};

function loadHeroStats() {
  const saved = localStorage.getItem(STORAGE_KEY);
  if (saved) {
    const data = JSON.parse(saved);
    return { ...defaultStats, ...data };
  }
  return { ...defaultStats };
}

function saveHeroStats(character) {
  const data = {
    hp: character.maxHp,
    attack: character.attack,
    defense: character.defense,
    speed: character.speed,
    mana: character.mana,
    critChance: character.critChance,
    level: character.level,
    xp: character.xp
  };
  localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

// === Classe personnage ===
class Character {
  constructor(name, stats) {
    this.name = name;
    this.maxHp = stats.hp;
    this.hp = stats.hp;
    this.attack = stats.attack;
    this.defense = stats.defense;
    this.speed = stats.speed;
    this.mana = stats.mana;
    this.critChance = stats.critChance;
    this.level = stats.level || 1;
    this.xp = stats.xp || 0;
    this.isDefending = false;
  }

  takeDamage(amount) {
    const damage = Math.max(0, amount - (this.isDefending ? this.defense * 2 : this.defense));
    this.hp -= damage;
    if (this.hp < 0) this.hp = 0;
    return damage;
  }

  isAlive() {
    return this.hp > 0;
  }
}

const player = new Character("Héros", loadHeroStats());

const enemies = [
  new Character("Gobelin", { hp: 60, attack: 8, defense: 3, speed: 5, mana: 0, critChance: 0.05 }),
  new Character("Loup Sauvage", { hp: 50, attack: 10, defense: 2, speed: 8, mana: 0, critChance: 0.1 }),
  new Character("Mage Noir", { hp: 40, attack: 12, defense: 2, speed: 4, mana: 30, critChance: 0.2 })
];

let enemy = enemies[Math.floor(Math.random() * enemies.length)];

function updateUI() {
  document.getElementById("hero-hp").textContent = player.hp;
  document.getElementById("enemy-hp").textContent = enemy.hp;
  document.getElementById("enemy-name").textContent = enemy.name;
  document.getElementById("hero-level").textContent = player.level;

  document.getElementById("hero-hp-bar").style.width = (player.hp / player.maxHp) * 100 + "%";
  document.getElementById("enemy-hp-bar").style.width = (enemy.hp / enemy.maxHp) * 100 + "%";
}

function log(message) {
  const li = document.createElement("li");
  li.textContent = message;
  document.getElementById("log-list").prepend(li);
}

function getCritMultiplier(chance) {
  return Math.random() < chance ? 2 : 1;
}

function enemyTurn() {
  if (!enemy.isAlive() || !player.isAlive()) return;

  enemy.isDefending = false;

  const crit = getCritMultiplier(enemy.critChance);
  const damage = Math.floor(enemy.attack * crit);
  const dmgTaken = player.takeDamage(damage);

  log(`${enemy.name} attaque et inflige ${dmgTaken} dégâts${crit > 1 ? " (Coup critique !)" : ""}.`);
  updateUI();

  checkEndGame();
}

document.getElementById("attack-btn").addEventListener("click", () => {
  if (!player.isAlive() || !enemy.isAlive()) return;

  player.isDefending = false;

  const crit = getCritMultiplier(player.critChance);
  const damage = Math.floor(player.attack * crit);
  const dmgDealt = enemy.takeDamage(damage);

  log(`Vous attaquez ${enemy.name} et infligez ${dmgDealt} dégâts${crit > 1 ? " (Coup critique !)" : ""}.`);
  updateUI();

  if (!checkEndGame()) {
    setTimeout(enemyTurn, 800);
  }
});

document.getElementById("defend-btn").addEventListener("click", () => {
  if (!player.isAlive() || !enemy.isAlive()) return;

  player.isDefending = true;
  log("Vous vous mettez en défense (+ défense x2 ce tour).");
  updateUI();

  setTimeout(enemyTurn, 800);
});

function checkEndGame() {
  const resultEl = document.getElementById("result-message");
  const restartBtn = document.getElementById("restart-btn");

  if (!player.isAlive()) {
    log("Vous avez été vaincu...");
    resultEl.textContent = "💀 Défaite !";
    restartBtn.style.display = "block";
    return true;
  }

  if (!enemy.isAlive()) {
    log(`Vous avez vaincu ${enemy.name} !`);
    resultEl.textContent = "🏆 Victoire !";
    restartBtn.style.display = "block";

    player.xp += 10;
    if (player.xp >= 20) {
      player.level++;
      player.xp = 0;
      player.maxHp += 10;
      player.attack += 2;
      player.defense += 1;
      log("🎉 Niveau supérieur !");
    }

    saveHeroStats(player);
    return true;
  }

  return false;
}

document.getElementById("restart-btn").addEventListener("click", () => {
  localStorage.removeItem(STORAGE_KEY);
  location.reload();
});

updateUI();
