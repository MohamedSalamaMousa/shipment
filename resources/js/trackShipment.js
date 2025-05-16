const puppeteer = require('puppeteer');
const path = require('path');
const fs = require('fs');

(async () => {
  try {
    const userDataDir = path.join(__dirname, 'temp', 'puppeteer');
    if (!fs.existsSync(userDataDir)) {
      fs.mkdirSync(userDataDir, { recursive: true });
    }

    const browser = await puppeteer.launch({
      headless: true,
      userDataDir,
    });

    const page = await browser.newPage();
    const barcode = process.argv[2] || 'ENO30052041EG';
    const url = `https://egyptpost.gov.eg/ar-eg/TrackTrace/GetShipmentDetails?barcode=${barcode}`;

    await page.goto(url, { waitUntil: 'networkidle0' });

    // Log page content for debugging
    const content = await page.content();
    console.log('Page HTML:', content);

    await page.waitForSelector('.table, .error-message', { timeout: 10000 }).catch(() => null);

    const trackingData = await page.evaluate(() => {
      const error = document.querySelector('.error-message');
      if (error) return `Error: ${error.innerText}`;

      const table = document.querySelector('.table');
      if (!table) return 'No tracking data found';

      const rows = Array.from(table.querySelectorAll('tr')).map(row => {
        const cells = row.querySelectorAll('td');
        return Array.from(cells).map(cell => cell.innerText.trim());
      });

      const formattedData = rows
        .filter(row => row.length > 0)
        .map(row => ({
          date: row[0] || '',
          time: row[1] || '',
          location: row[2] || '',
          status: row[3] || '',
        }));

      return formattedData.length > 0 ? formattedData : 'No tracking data found';
    });

    await browser.close();
    console.log(JSON.stringify({ trackingData }));
  } catch (error) {
    console.error(JSON.stringify({ error: error.message }));
    process.exit(1);
  }
})();