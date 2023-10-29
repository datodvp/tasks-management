// Function to convert 'hh:mm:ss' time format to minutes
function timeToMinutes(time) {
    // Split the time into its components
    const [hours, minutes, seconds] = time.split(":").map(Number);

    // Calculate the total minutes, ignoring seconds
    return hours * 60 + minutes;
}

// Function to convert minutes to 'hh:mm' time format
function minutesToTime(minutes) {
    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    return `${String(hours).padStart(2, "0")}:${String(
        remainingMinutes
    ).padStart(2, "0")}`;
}

// Function to sum two 'hh:mm:ss' times and return 'hh:mm' format
export function sumTimes(time1, time2) {
    const totalMinutes = timeToMinutes(time1) + timeToMinutes(time2);
    return minutesToTime(totalMinutes);
}
