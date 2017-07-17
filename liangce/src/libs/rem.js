/**
 * Created by 海枯 <haiku888@foxmail.com> on 2016/12/26.
 */
const changeFontSize = function () {
    const iWidth = window.innerWidth;
    let fSize;
    if (iWidth <= 750) {
        fSize = iWidth / 750 * 100;
    } else {
        fSize = 100;
    }
    const html = document.documentElement;
    html.style.fontSize = fSize + 'px';
    html.style.margin = '0 auto';
    html.style.maxWidth = '750px';
}
changeFontSize();
window.onresize = changeFontSize;