const candidateProfile = {
  info: {
    name: "Jane Doe",
    headline: "Frontend Developer",
    location: "Paris, France",
    bio: "Creative developer passionate about UI/UX and interaction design.",
    contacts: [
      { type: "Email", value: "jane@example.com" },
      { type: "LinkedIn", value: "linkedin.com/in/janedoe" },
    ]
  },
  diplomas: [
    {
      title: "B.Sc. in Computer Science",
      school: "Université de Paris",
      year: 2018,
      description: "Focused on software engineering and HCI."
    }
  ],
  experiences: [
    {
      title: "Frontend Engineer",
      company: "TechSoft",
      dates: "2019–2022",
      missions: ["Built reusable UI components", "Improved site accessibility"]
    }
  ],
  achievements: [
    {
      name: "Portfolio Website",
      description: "Custom-built portfolio in vanilla JS and CSS.",
      link: "https://jane.dev"
    }
  ],
  documents: [
    { name: "CV (PDF)", link: "#" },
    { name: "GitHub", link: "https://github.com/janedoe" }
  ]
};

// Helpers
const overlay = document.getElementById("modal-overlay");
const modalTitle = document.getElementById("modal-title");
const modalContent = document.getElementById("modal-content");

function openModal(section) {
  modalTitle.textContent = capitalize(section);
  modalContent.innerHTML = generateContent(section);
  overlay.classList.remove("hidden");
}

function closeModal() {
  overlay.classList.add("hidden");
}

function generateContent(section) {
  const data = candidateProfile[section];
  if (!data) return "<p>No data available.</p>";

  switch (section) {
    case "info":
      return `
        <p><strong>${data.name}</strong></p>
        <p>${data.headline} — ${data.location}</p>
        <p>${data.bio}</p>
        <ul>${data.contacts.map(c => `<li>${c.type}: ${c.value}</li>`).join('')}</ul>
      `;
    case "diplomas":
    case "experiences":
      return data.map(item => `
        <div>
          <h3>${item.title} ${item.school || item.company ? `– ${item.school || item.company}` : ''}</h3>
          <small>${item.year || item.dates}</small>
          <p>${item.description || item.missions?.join(", ")}</p>
        </div>
      `).join('');
    case "achievements":
      return data.map(p => `
        <div>
          <h3>${p.name}</h3>
          <p>${p.description}</p>
          <a href="${p.link}" target="_blank">View project</a>
        </div>
      `).join('');
    case "documents":
      return `<ul>${data.map(d => `<li><a href="${d.link}" target="_blank">${d.name}</a></li>`).join('')}</ul>`;
    case "photo":
      return `<img src="assets/photo.jpg" alt="Candidate photo" style="max-width: 100%;">`;
    default:
      return "<p>Section not found.</p>";
  }
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Events
document.querySelectorAll(".zone").forEach(zone => {
  zone.addEventListener("click", () => openModal(zone.dataset.section));
});
overlay.addEventListener("click", (e) => {
  if (e.target === overlay || e.target.classList.contains('close-btn')) {
    closeModal();
  }
});
