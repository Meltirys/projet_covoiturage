document.addEventListener('DOMContentLoaded', () => {
    let startDrive = document.getElementById('start-formation-drive')
    let endDrive = document.getElementById('end-formation-drive')
    let startRequest = document.getElementById('start-formation-request')
    let endRequest = document.getElementById('end-formation-request')

    if (startDrive && endDrive) {
        //Start listener
        startDrive.addEventListener('change', (e) => {
            let driveStartInput = document.getElementById('drive-start')

            if (e.currentTarget.checked) {
                driveStartInput.value = schoolName // We set the name to the school name
                driveStartInput.disabled = true
                driveStartInput.required = false

                // Décoche l'autre checkbox ET force le déclenchement de son événement 'change'
                if (endDrive.checked) {
                    endDrive.checked = false
                    endDrive.dispatchEvent(new Event('change'))
                }
            }
            else {
                driveStartInput.disabled = false
                driveStartInput.value = ""
                driveStartInput.required = true
            }
        })

        //End listener
        endDrive.addEventListener('change', (e) => {
            let driveEndInput = document.getElementById('drive-end')

            if (e.currentTarget.checked) {
                driveEndInput.value = schoolName // We set the name to the school name
                driveEndInput.disabled = true
                driveEndInput.required = false

                // Décoche l'autre checkbox ET force le déclenchement de son événement 'change'
                if (startDrive.checked) {
                    startDrive.checked = false
                    startDrive.dispatchEvent(new Event('change'))
                }
            }
            else {
                driveEndInput.disabled = false
                driveEndInput.value = ""
                driveEndInput.required = true
            }
        })
    }

    if (startRequest && endRequest) {
        //Start listener
        startRequest.addEventListener('change', (e) => {
            let requestStartInput = document.getElementById('request-start')

            if (e.currentTarget.checked) {
                requestStartInput.value = schoolName // We set the name to the school name
                requestStartInput.disabled = true
                requestStartInput.required = false

                // Décoche l'autre checkbox ET force le déclenchement de son événement 'change'
                if (endRequest.checked) {
                    endRequest.checked = false
                    endRequest.dispatchEvent(new Event('change'))
                }
            }
            else {
                requestStartInput.disabled = false
                requestStartInput.value = ""
                requestStartInput.required = true
            }
        })

        //End listener
         endRequest.addEventListener('change', (e) => {
            let requestEndInput = document.getElementById('request-end')

            if (e.currentTarget.checked) {
                requestEndInput.value = schoolName // We set the name to the school name
                requestEndInput.disabled = true
                requestEndInput.required = false

                // Décoche l'autre checkbox ET force le déclenchement de son événement 'change'
                if (startRequest.checked) {
                    startRequest.checked = false
                    startRequest.dispatchEvent(new Event('change'))
                }
            }
            else {
                requestEndInput.disabled = false
                requestEndInput.value = ""
                requestEndInput.required = true
            }
        })
    }
})