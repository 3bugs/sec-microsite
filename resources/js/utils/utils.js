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
