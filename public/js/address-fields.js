reportManagementPaginator = new Paginator(
    document.querySelector('#researchResultsReport'),
    document.querySelector('#paginationReport'),
    renderReportManagement
)

reportHistoryPaginator = new Paginator(
    document.querySelector('#researchResultsReportHistory'),
    document.querySelector('#paginationReportHistory'),
    renderReportHistory
)

function renderReportManagement(element) {
    let reportDiv       = document.createElement('div')
    let reportHeader    = document.createElement('div')
    let reportBody      = document.createElement('div')
    let reporterReported = document.createElement('p')
    let dateOfReport    = document.createElement('p')
    let reportReasonText = document.createElement('p')
    let reportComment   = document.createElement('p')
    let resolvedForm    = document.createElement('form')
    let csrfToken       = document.createElement('input')
    let resolvedButton  = document.createElement('button')

    reporterReported.textContent = (element['reporter_name'] ?? 'utilisateur supprimé') + ' a signalé ' + (element['reported_name'] ?? 'utilisateur supprimé')
    dateOfReport.textContent     = element['date']
    reportComment.textContent    = element['comment']
    reportReasonText.textContent = 'Message lié au signalement :'

    resolvedForm.appendChild(csrfToken)
    resolvedForm.appendChild(resolvedButton)
    resolvedForm.method = 'POST'
    resolvedForm.action = 'report/solve/' + element['id_report']
    resolvedButton.type = 'submit'
    resolvedButton.textContent = 'Marquer comme résolu'

    csrfToken.type  = 'hidden'
    csrfToken.name  = document.querySelector('meta[name="csrf-name"]').content
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

    reportDiv.className          = 'flex flex-col gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors'
    reportHeader.className       = 'flex items-center justify-between gap-3'
    reporterReported.className   = 'text-sm font-medium text-lightgrey'
    dateOfReport.className       = 'text-xs text-grey whitespace-nowrap'
    reportBody.className         = 'flex flex-col gap-1'
    reportReasonText.className   = 'text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey'
    reportComment.className      = 'text-xs text-lightgrey'
    resolvedButton.className     = 'text-xs border border-gold/40 text-gold rounded-full px-3 py-1 hover:bg-gold/10 transition-colors cursor-pointer self-end'

    reportHeader.appendChild(reporterReported)
    reportHeader.appendChild(dateOfReport)
    reportBody.appendChild(reportReasonText)
    reportBody.appendChild(reportComment)
    reportDiv.appendChild(reportHeader)
    reportDiv.appendChild(reportBody)
    reportDiv.appendChild(resolvedForm)
    return reportDiv
}

function renderReportHistory(element) {
    let reportDiv        = document.createElement('div')
    let reportHeader     = document.createElement('div')
    let reportBody       = document.createElement('div')
    let reporterReported = document.createElement('p')
    let dateOfReport     = document.createElement('p')
    let reportReasonText = document.createElement('p')
    let reportComment    = document.createElement('p')

    reporterReported.textContent = (element['reporter_name'] ?? 'utilisateur supprimé') + ' a signalé ' + (element['reported_name'] ?? 'utilisateur supprimé')
    dateOfReport.textContent     = element['date']
    reportComment.textContent    = element['comment']
    reportReasonText.textContent = 'Message lié au signalement :'

    reportDiv.className        = 'flex flex-col gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 opacity-60'
    reportHeader.className     = 'flex items-center justify-between gap-3'
    reporterReported.className = 'text-sm font-medium text-lightgrey'
    dateOfReport.className     = 'text-xs text-grey whitespace-nowrap'
    reportBody.className       = 'flex flex-col gap-1'
    reportReasonText.className = 'text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey'
    reportComment.className    = 'text-xs text-lightgrey'

    reportHeader.appendChild(reporterReported)
    reportHeader.appendChild(dateOfReport)
    reportBody.appendChild(reportReasonText)
    reportBody.appendChild(reportComment)
    reportDiv.appendChild(reportHeader)
    reportDiv.appendChild(reportBody)
    return reportDiv
}