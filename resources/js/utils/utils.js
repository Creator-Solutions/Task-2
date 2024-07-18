
/**
 * ------------------
 * Utility Class
 * -----------------
 *
 * Contains convenience
 * methods to use in the
 * application
 */
export class Util {
    static formatDate(isoString) {
        // Parse the ISO 8601 string
        const date = new Date(isoString);

        // Get individual components
        const day = date.getDate().toString().padStart(2, "0"); // Pad single digit days with leading zero
        const month = (date.getMonth() + 1).toString().padStart(2, "0"); // Months are zero-based
        const year = date.getFullYear();
        const hours = date.getHours() % 12 || 12; // Convert to 12-hour format and handle midnight (0)
        const minutes = date.getMinutes().toString().padStart(2, "0"); // Pad single digit minutes with leading zero
        const ampm = date.getHours() >= 12 ? "PM" : "AM"; // Determine AM/PM

        // Construct the human-readable string
        const humanReadableDate = `${day}-${month}-${year} ${hours}:${minutes} ${ampm}`;

        return humanReadableDate;
    }
}
