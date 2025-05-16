// node_scripts/track.js
const puppeteer = require('puppeteer');

(async () => {
  const barcode = process.argv[2];
  if (!barcode) {
    console.error('Please provide a barcode!');
    process.exit(1);
  }

  const url = 'https://egyptpost.gov.eg/ar-eg/TrackTrace';

  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();

  await page.goto(url, { waitUntil: 'networkidle2' });

  // عدّل selectors حسب الصفحة الحقيقية
  await page.type('#Barcode', barcode);
  await Promise.all([
    page.click('#btnTrack'),
    page.waitForNavigation({ waitUntil: 'networkidle2' }),
  ]);

  const result = await page.evaluate(() => {
    // عدّل هذا الجزء ليتناسب مع بيانات الصفحة
    const el = document.querySelector('.shipment-info');
    return el ? el.innerText : 'لا توجد بيانات';
  });

  console.log(result);

  await browser.close();
})();
