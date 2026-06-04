//Creating the paginator for manger
reportManagementPaginator = new Paginator(
    document.querySelector('#researchResultsReport'),
    document.querySelector('#paginationReport'),
    renderReportManagement
)

//Creating the paginator for the history
reportHistoryPaginator = new Paginator(
    document.querySelector('#researchResultsReportHistory'),
    document.querySelector('#paginationReportHistory'),
    renderReportHistory
)

function renderReportManagement(element) {
    //Creating the elements
    let reportDiv = document.createElement('div')
    let reportHeader = document.createElement('div')
    let reportBody = document.createElement('div')
    let reportActions = document.createElement('div')
    let reporterReported = document.createElement('p')
    let dateOfReport = document.createElement('p')
    let reportReasonText = document.createElement('p')
    let reportComment = document.createElement('p')
    let resolvedForm = document.createElement('form')
    let csrfToken = document.createElement('input')
    let resolvedButton = document.createElement('button')

    //Filling up the datas
    reporterReported.textContent = (element['reporter_name'] ?? 'utilisateur supprimé') + " à signalé " + (element['reported_name'] ?? 'utilisateur_supprimé')
    dateOfReport.textContent = element['date']
    reportComment.textContent = element['comment']
    reportReasonText.textContent = "Message lié au signalement :"



    //Setting up the form
    resolvedForm.appendChild(csrfToken)
    resolvedForm.appendChild(resolvedButton)
    resolvedForm.method = "POST"
    resolvedForm.action = "report/solve/" + element['id_report']
    resolvedButton.type = "submit"
    resolvedButton.textContent = "Marquer comme résolu"
    //CSRF token
    csrfToken.type = "hidden"
    csrfToken.name = document.querySelector('meta[name="csrf-name"]').content
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

    //Adding the styles
    reportDiv.className = "flex items-center justify-between bg-white border border-babyblue rounded-lg px-4 py-3 shadow-sm"
    resolvedButton.className = "btn-danger"


    //Building everything together
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
    //Creating the elements
    let reportDiv = document.createElement('div')
    let reportHeader = document.createElement('div')
    let reportBody = document.createElement('div')
    let reporterReported = document.createElement('p')
    let dateOfReport = document.createElement('p')
    let reportReasonText = document.createElement('p')
    let reportComment = document.createElement('p')

    //Filling up the datas
    reporterReported.textContent = (element['reporter_name'] ?? 'utilisateur supprimé') + " à signalé " + (element['reported_name'] ?? 'utilisateur_supprimé')
    dateOfReport.textContent = element['date']
    reportComment.textContent = element['comment']
    reportReasonText.textContent = "Message lié au signalement :"


    //Adding the styles
    reportDiv.className = "flex items-center justify-between bg-white border border-babyblue rounded-lg px-4 py-3 shadow-sm"

    //Building everything together
    reportHeader.appendChild(reporterReported)
    reportHeader.appendChild(dateOfReport)
    reportBody.appendChild(reportReasonText)
    reportBody.appendChild(reportComment)

    reportDiv.appendChild(reportHeader)
    reportDiv.appendChild(reportBody)

    return reportDiv
}