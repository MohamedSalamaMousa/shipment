const puppeteer = require('puppeteer');

async function getShipmentDetails(barcode) {
  const url = `https://egyptpost.gov.eg/ar-eg/TrackTrace/GetShipmentDetails?barcode=${barcode}`;

  const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox'] });
  const page = await browser.newPage();

  await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36');
  await page.goto(url, { waitUntil: 'networkidle2' });

  // Extract relevant data from the page (modify selector as needed)
  const data = await page.evaluate(() => {
    const container = document.querySelector('.table-responsive') || document.body;
    return container.innerText || 'No tracking info found';
  });

  await browser.close();

  // Output JSON string with the data
  console.log(JSON.stringify({ trackingData: data }));
}

const barcode = process.argv[2];
if (!barcode) {
  console.error('Barcode argument missing!');
  process.exit(1);
}

getShipmentDetails(barcode)
  .catch(err => {
    console.error(JSON.stringify({ error: err.message }));
    process.exit(1);
  });
