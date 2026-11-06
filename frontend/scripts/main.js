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

// Kontaktformular: sendet die Nachricht per E-Mail über den Server (ohne JavaScript läuft es über eine Weiterleitung)
document.querySelectorAll('form[data-contact]').forEach((f) => {
  const status = f.querySelector('.form-status')
  const button = f.querySelector('.submit')
  const show = (text, isError) => {
    status.textContent = text
    status.classList.toggle('is-error', isError)
  }
  f.addEventListener('submit', async (e) => {
    e.preventDefault()
    if (!f.checkValidity()) return f.reportValidity()
    const data = new FormData(f)
    data.append('ajax', '1')
    button.disabled = true
    show('Wird gesendet …', false)
    try {
      const res = await fetch(f.action, { method: 'POST', body: data, headers: { Accept: 'application/json' } })
      const json = await res.json()
      const text = (json && json.data && json.data.message) || 'Das hat leider nicht geklappt. Bitte versuch es später nochmals.'
      show(text, !(json && json.success))
      if (json && json.success) f.reset()
    } catch (err) {
      show('Das hat leider nicht geklappt. Bitte versuch es später nochmals oder melde dich über LinkedIn oder Instagram.', true)
    } finally {
      button.disabled = false
    }
  })
})
