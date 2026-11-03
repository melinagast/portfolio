// Projekt-Filter
document.querySelectorAll('[data-filter]').forEach((bar) => {
  const cards = document.querySelectorAll('.project-card')
  bar.addEventListener('click', (e) => {
    const b = e.target.closest('.pill'); if (!b) return
    bar.querySelectorAll('.pill').forEach((x) => x.classList.toggle('active', x === b))
    const t = b.dataset.term
    cards.forEach((c) => { c.hidden = !(t === 'all' || c.dataset.terms.split(' ').includes(t)) })
  })
})

// Ergebnis/Prozess-Umschalter
document.querySelectorAll('[data-tabs]').forEach((box) => {
  box.addEventListener('click', (e) => {
    const b = e.target.closest('[data-tab]'); if (!b) return
    box.querySelectorAll('[data-tab]').forEach((x) => x.classList.toggle('active', x === b))
    box.querySelectorAll('[data-panel]').forEach((p) => { p.hidden = p.dataset.panel !== b.dataset.tab })
  })
})

// Arbeitsfelder: Band stoppt, Tippen öffnet Detail
const sec = document.querySelector('[data-module="arbeitsfelder_auswahl"]')
if (sec) {
  const band = sec.querySelector('[data-marquee]')
  const close = () => { sec.querySelectorAll('.detail').forEach((d) => (d.hidden = true)); band.classList.remove('paused') }
  sec.addEventListener('click', (e) => {
    if (e.target.closest('[data-close]')) return close()
    const t = e.target.closest('[data-field]'); if (!t) return
    close()
    const d = sec.querySelector('#field-' + t.dataset.field)
    d.hidden = false; band.classList.add('paused'); d.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
  })
}
