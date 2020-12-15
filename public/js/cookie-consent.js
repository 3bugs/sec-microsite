window.ccState = {
  panelOpen: false,
}

window.cookieManager = {
  write: (key, value) => {
    document.cookie = `${key}=${encodeURIComponent(JSON.stringify(value))}; path=/`
  },
  read: key => {
    const match = document.cookie.match(`(^|[^;]+)\\s*${key}\\s*=\\s*([^;]+)`)
    if (!match) return undefined
    return JSON.parse(match.pop())
  },
}

window.COOKIE_KEYS = {
  AUTO_SHOW: 'CC_AUTO_SHOW',
  ALLOW_GA: 'CC_ALLOW_GA',
}

const $ccPanel = $('#cc-control-panel')
const $ccBackdrop = $('#cc-backdrop')
const $ccPanelTrigger = $('#cc-panel-trigger')
const $ccGaSwitchInput = $('#cc-ga-switch-input')
const $ccSaveButton = $('#cc-save')
const $ccPanelTriggerText = $('.cookie-trigger small')

const panel = {
  open: () => {
    $ccPanel.addClass('-open')
    $ccBackdrop.addClass('-open')
    window.ccState.panelOpen = true
  },
  close: () => {
    $ccPanel.removeClass('-open')
    $ccBackdrop.removeClass('-open')
    window.ccState.panelOpen = false

    // Save state that autoShow has been done
    if (!cookieManager.read(COOKIE_KEYS.AUTO_SHOW)) {
      cookieManager.write(COOKIE_KEYS.AUTO_SHOW, true)
    }
  },
  save: () => {
    const allowGa = $ccGaSwitchInput.is(':checked')
    cookieManager.write(COOKIE_KEYS.ALLOW_GA, allowGa)

    // init GA right away if ga is allow and not initialized before
    if (allowGa && typeof ga === 'undefined') {
      initGA()
    }
  },
}

$ccPanelTriggerText.on('click', event => {
  panel.open()
})

// EVENT LISTENERS
$ccPanelTrigger.on('click', () => {
  if (window.ccState.panelOpen) {
    panel.close()
  } else {
    panel.open()
  }
})
$ccBackdrop.on('click', () => {
  panel.close()
})
$ccSaveButton.on('click', event => {
  event.preventDefault()
  panel.save()
  panel.close()
})

// On ready
$(document).ready(() => {
  const autoShow = cookieManager.read(COOKIE_KEYS.AUTO_SHOW)
  const allowGA = cookieManager.read(COOKIE_KEYS.ALLOW_GA)

  // Auto show the cookie panel if the autoShow has never been done
  if (!autoShow) {
    panel.open()
  }

  if (allowGA) {
    $ccPanelTrigger.prop('checked', true)
    initGA()
  }
})

function initGA() {
  return;
  console.log('Initializing Google Analytics...');

  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r
    i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date()
    a = s.createElement(o),
      m = s.getElementsByTagName(o)[0]
    a.async = 1
    a.src = g
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga')

  ga('create', 'UA-XXXXX-Y', 'auto') // todo: change Tracking ID ***********************
  ga('send', 'pageview')
}
