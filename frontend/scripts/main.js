// Navigation: aktuelle Seite unterstreichen (Projekt-Einzelseiten zählen zu «Projekte»)
document.querySelectorAll('[data-layout="header"] .nav a').forEach((a) => {
  const path = a.pathname.replace(/\/$/, '')
  const here = location.pathname.replace(/\/$/, '')
  const isProjectPage = document.querySelector('[data-page="project"]') && /\/projekte$/.test(path)
  if ((path && path === here && path !== '') || isProjectPage) a.setAttribute('aria-current', 'page')
})

// Projekt-Filter
document.querySelectorAll('[data-filter]').forEach((bar) => {
  const cards = document.querySelectorAll('[data-module="projekte_archiv"] .project-card')
  bar.addEventListener('click', (e) => {
    const b = e.target.closest('.pill'); if (!b) return
    bar.querySelectorAll('.pill').forEach((x) => { x.classList.toggle('active', x === b); x.setAttribute('aria-pressed', x === b) })
    const t = b.dataset.term
    cards.forEach((c) => { c.hidden = !(t === 'all' || c.dataset.terms.split(' ').includes(t)) })
  })
})

// Ergebnis/Prozess-Umschalter
document.querySelectorAll('[data-tabs]').forEach((box) => {
  box.addEventListener('click', (e) => {
    const b = e.target.closest('[data-tab]'); if (!b) return
    box.querySelectorAll('[data-tab]').forEach((x) => { x.classList.toggle('active', x === b); x.setAttribute('aria-pressed', x === b) })
    box.querySelectorAll('[data-panel]').forEach((p) => { p.hidden = p.dataset.panel !== b.dataset.tab })
  })
})

// Arbeitsfelder: Band stoppt, Tippen öffnet Detail
const sec = document.querySelector('[data-module="arbeitsfelder_auswahl"]')
if (sec) {
  const band = sec.querySelector('[data-marquee]')
  const close = () => {
    sec.querySelectorAll('.detail').forEach((d) => (d.hidden = true))
    sec.querySelectorAll('.tile').forEach((t) => t.classList.remove('on'))
    band.classList.remove('paused')
  }
  sec.addEventListener('click', (e) => {
    if (e.target.closest('[data-close]')) return close()
    const t = e.target.closest('[data-field]'); if (!t) return
    const was = t.classList.contains('on')
    close()
    if (was) return
    const d = sec.querySelector('#field-' + t.dataset.field)
    d.hidden = false; band.classList.add('paused')
    sec.querySelectorAll('[data-field="' + t.dataset.field + '"]').forEach((x) => x.classList.add('on'))
    d.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
  })
}

// Kontaktformular: öffnet das E-Mail-Programm mit fertigem Text (nichts wird auf dem Server gespeichert)
document.querySelectorAll('form[data-mailto]').forEach((f) => {
  f.addEventListener('submit', (e) => {
    e.preventDefault()
    const v = (n) => f.elements[n].value.trim()
    const body = v('msg') + '\n\n' + v('name') + '\n' + v('mail')
    location.href = 'mailto:' + f.dataset.mailto + '?subject=' + encodeURIComponent('Nachricht von ' + v('name')) + '&body=' + encodeURIComponent(body)
  })
})
