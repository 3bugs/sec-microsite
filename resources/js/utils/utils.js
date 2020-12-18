export function formatThaiDateTime(dateTimeString) {
  const date = new Date(dateTimeString);
  return date.toLocaleString('th-TH');

  /*const thaiShortMonthNames = [
    'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.',
  ];
  const mainParts = dateTimeString.split(' ');

  const dateParts = mainParts[0].split('-');
  const yearThai = parseInt(dateParts[0]) + 543;
  const month = thaiShortMonthNames[parseInt(dateParts[1]) - 1];
  const day = parseInt(dateParts[2]);

  const timeParts = mainParts[1].split(':');
  const hour = timeParts[0];
  const minute = timeParts[1];
  const second = timeParts[2];

  return `${day} ${month} ${yearThai}, ${hour}.${minute} น.`;*/
}

export function getThaiDateText([beginDate, endDate], yearDigits = 4) {
  //alert('Begin date: ' + beginDate + ', End date: ' + endDate);

  if (beginDate === endDate || endDate == null) {
    const {day, month, year} = dateSplit(beginDate, yearDigits);
    return `${day} ${month} ${year}`.trim();
  }

  const beginDateParts = dateSplit(beginDate, yearDigits);
  const endDateParts = dateSplit(endDate, yearDigits);

  if (beginDateParts.month === endDateParts.month && beginDateParts.year === endDateParts.year) {
    return `${beginDateParts.day} - ${endDateParts.day} ${beginDateParts.month} ${beginDateParts.year}`.trim();
  }

  if (beginDateParts.year === endDateParts.year) {
    return `${beginDateParts.day} ${beginDateParts.month} - ${endDateParts.day} ${endDateParts.month} ${beginDateParts.year}`.trim();
  }

  return `${beginDateParts.day} ${beginDateParts.month} ${beginDateParts.year} - ${endDateParts.day} ${endDateParts.month} ${endDateParts.year}`.trim();
}

export function dateSplit(dateText, yearDigits) {
  const monthNames = [
    'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
    'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.',
  ];
  const beginDateParts = dateText.split('-');
  const day = parseInt(beginDateParts[2]);
  const month = monthNames[parseInt(beginDateParts[1]) - 1];
  const yearFull = (parseInt(beginDateParts[0]) + 543).toString();
  const year = yearDigits === 0 ? '' : yearFull.substring(yearFull.length - yearDigits);
  return {day, month, year};
}

export function nl2br(str, is_xhtml) {
  if (typeof str === 'undefined' || str === null) {
    return '';
  }
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
