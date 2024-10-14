(()=>{"use strict";var t={944:(t,e,n)=>{n.d(e,{Z:()=>s});const s=t=>{var e=parseInt(t,10),n=Math.floor(e/3600),s=Math.floor((e-3600*n)/60),a=e-3600*n-60*s;return n<10&&(n="0"+n),s<10&&(s="0"+s),a<10&&(a="0"+a),s+":"+a}}},e={};function n(s){var a=e[s];if(void 0!==a)return a.exports;var i=e[s]={exports:{}};return t[s](i,i.exports,n),i.exports}n.d=(t,e)=>{for(var s in e)n.o(e,s)&&!n.o(t,s)&&Object.defineProperty(t,s,{enumerable:!0,get:e[s]})},n.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(()=>{const t=(e,n)=>{const s=Math.floor(Math.random()*e);return n===s?t(e,n):s},e=t;var s=n(944);const a=class{constructor(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];return this.shuffle=!1,this.repeat=!1,this.currentIndex=0,this.player=null,this.isAdmin=e?.isAdmin,this.prevIndex=null,this.playlist(t,e,n)}playlist(t){let n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];if(!t)return null;const i="AUDIO"===t?.tagName?t:t.querySelector("audio"),l=new Plyr(i,n);this.player=l;const r=t?.dataset?.infos&&(t=>{let e=null;try{e=JSON.parse(t)}catch(t){console.warn(t.message)}return e})(t.dataset.infos)||{},o=t.querySelector("[data-plyr=play2]"),d=t.querySelector("[data-plyr=artist]"),p=t.querySelector("[data-plyr=title]"),c=t.querySelector("[data-plyr=prev]"),u=t.querySelector("[data-plyr=next]"),v=t.querySelector("[data-plyr=shuffle]"),y=t.querySelector("[data-plyr=repeat]"),m=t.querySelectorAll("[data-audio-item]"),h=t.querySelector("[data-plyr=cover]");if(y?.addEventListener("click",(t=>{this.handleFeature(t)})),v?.addEventListener("click",(t=>this.handleFeature(t))),a.length||m.forEach((t=>a.push({source:t.dataset?.audioSource}))),!a.length)return!1;l.on("ready",(()=>{this.isAdmin||this.dispatchEvent(this.currentIndex,!1)})),window.h5apPlayer?.multipleAudio||l.on("play",(()=>{document.querySelectorAll("audio").forEach((t=>{t.isEqualNode(i)||t.pause()}))})),window.player=l,window.dom=t,m.forEach(((t,e)=>{const n=document.createElement("audio");a[e]?.source&&(n.src=a[e]?.source,n.addEventListener("loadedmetadata",(()=>{t.querySelector(".duration")&&(t.querySelector(".duration").innerText=(0,s.Z)(n.duration))}))),t.addEventListener("click",(()=>{window.player=l,this.currentIndex===e?l.playing?l.pause():l.play():(this.prevIndex=e>0?e-1:a.length-1,this.currentIndex=e,this.dispatchEvent(this.currentIndex))}))})),l.on("updateTrack",(t=>{let{detail:e}=t;const{title:n,artist:s,source:r,poster:o}=a[e?.index];this.prevIndex===e.index&&l.playing?l.pause():(h&&(h.src=o),i&&(i.src=r),p&&(p.innerText=n),d&&(d.innerText=s),e.play&&l.play()),m.forEach((t=>{t.classList.remove("item-active"),t.classList.remove("item-playing")})),m[e?.index].classList.add("item-active")})),l.on("ended",(()=>{this.repeat?this.dispatchEvent(this.currentIndex):r?.autoplayNextTrack&&(this.prevIndex=this.currentIndex,this.shuffle?(this.currentIndex=e(a.length,this.currentIndex),this.dispatchEvent(this.currentIndex)):(this.currentIndex=a.length>this.currentIndex+1?this.currentIndex+1:0,this.dispatchEvent(this.currentIndex)))}));const g=t.querySelector(".song-played-progress");return g?.addEventListener("click",(function(t){const e=l.duration/g.offsetWidth;l.currentTime=t.offsetX*e})),l.on("timeupdate",(function(){g?.setAttribute("value",100/l.duration*l.currentTime)})),o?.addEventListener("click",(function(){l.playing?l.pause():l.play()})),l.on("play",(()=>{o?.classList.add("playing"),o?.classList.remove("paused"),m[this.currentIndex]?.classList.add("item-playing")})),l.on("pause",(()=>{o?.classList.add("paused"),o?.classList.remove("playing"),m[this.currentIndex]?.classList.remove("item-playing")})),u?.addEventListener("click",(()=>{const t=a.length>this.currentIndex+1?this.currentIndex+1:0;this.prevIndex=this.currentIndex,this.currentIndex=t,this.dispatchEvent(t)})),c?.addEventListener("click",(()=>{const t=this.currentIndex>0?this.currentIndex-1:this.currentIndex;this.currentIndex!==t&&(this.prevIndex=this.currentIndex,this.currentIndex=t),this.dispatchEvent(t)})),l}handleFeature(t){"false"!==(t.target?.dataset.active||"false")?(t.target.dataset.active=!1,this[t.target?.dataset?.plyr]=!1):(t.target.dataset.active=!0,this[t.target?.dataset?.plyr]=!0),window.event=t}dispatchEvent(t){const e=new CustomEvent("updateTrack",{detail:{index:t,play:!(arguments.length>1&&void 0!==arguments[1])||arguments[1]}});this.player?.elements?.container?.dispatchEvent(e)}},i=function(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[];return`<div class="flat-black-player-container playlist_container">\n      <div id="list-screen" class="slide-in-top">\n        <div id="list-screen-header" class="hide-playlist">\n          <img id="up-arrow" src="https://521dimensions.com/img/open-source/amplitudejs/examples/flat-black/up.svg"/>\n          Hide Playlist\n        </div>\n        <div id="list">\n          \n          ${t.map(((t,e)=>{let{title:n,artist:s}=t;return`\n            <div class="song amplitude-song-container amplitude-play-pause" data-audio-item data-index="${e}">\n              <span class="song-number-now-playing">\n                <span class="number">${e+1}</span>\n                <img class="now-playing" src="https://521dimensions.com/img/open-source/amplitudejs/examples/flat-black/now-playing.svg"/>\n              </span>\n  \n              <div class="song-meta-container">\n                <span class="song-name" data-amplitude-song-info="name" data-amplitude-song-index="0">${n||""}</span>\n                <span class="song-artist-album"><span data-amplitude-song-info="artist" data-amplitude-song-index="0">${s||""}</span>\n              </div>\n              <span class="duration">3:30<span>\n            </div>`})).join("")}\n        </div>\n  \n        <div id="list-screen-footer">\n          <div id="list-screen-meta-container">\n            <span data-amplitude-song-info="name" class="song-name"></span>\n  \n            <div class="song-artist-album">\n              <span data-amplitude-song-info="artist"></span>\n            </div>\n          </div>\n          <div class="list-controls">\n            <div class="list-previous amplitude-prev"></div>\n            <div class="list-play-pause amplitude-play-pause paused" data-plyr="play2"></div>\n            <div class="list-next amplitude-next"></div>\n          </div>\n        </div>\n      </div>\n      <div id="player-screen">\n        <div class="player-header down-header">\n          <img id="down" src="https://521dimensions.com/img/open-source/amplitudejs/examples/flat-black/down.svg"/>\n          Show Playlist\n        </div>\n        <div id="player-top">\n          <img data-amplitude-song-info="cover_art_url" data-plyr="cover" src="${t[0]?.poster}"/>\n        </div>\n        <div id="player-progress-bar-container">\n          <progress class="song-played-progress" min="0" max="100" step="0.01"></progress>\n          <progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>\n        </div>\n        \n        <div id="player-middle">\n          <div id="time-container">\n            <span class="amplitude-current-time time-container plyr__time--current"></span>\n            <span class="amplitude-duration-time time-container plyr__time--duration"></span>\n          </div>\n          <div id="meta-container">\n            <span data-amplitude-song-info="name" class="song-name"></span>\n  \n            <div class="song-artist-album">\n              <span data-amplitude-song-info="artist"></span>\n            </div>\n          </div>\n        </div>\n        <div id="player-bottom">\n          <div id="control-container">\n  \n            <div id="shuffle-container">\n              <div class="amplitude-shuffle amplitude-shuffle-off" data-plyr="shuffle" id="shuffle"></div>\n            </div>\n  \n            <div id="prev-container">\n              <div class="amplitude-prev" data-plyr="prev" id="previous"></div>\n            </div>\n  \n            <div id="play-pause-container">\n              <div class="amplitude-play-pause" data-plyr="play" id="play-pause"></div>\n            </div>\n  \n            <div id="next-container">\n              <div class="amplitude-next" data-plyr="next" id="next"></div>\n            </div>\n  \n            <div id="repeat-container">\n              <div class="amplitude-repeat" id="repeat" data-plyr="repeat"></div>\n            </div>\n  \n          </div>\n          <div id="volume-container">\n            <button type="button" class="plyr__control" aria-label="Mute" data-plyr="mute">\n              <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-muted"></use></svg>\n              <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-volume"></use></svg>\n              <span class="label--pressed plyr__tooltip" role="tooltip">Unmute</span>\n              <span class="label--not-pressed plyr__tooltip" role="tooltip">Mute</span>\n            </button>\n            <input data-plyr="volume" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" aria-label="Volume" class="amplitude-volume-slider">\n          </div>\n        </div>\n      </div>\n    </div>`},l=function(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[];return`\n    <div class="playlist_container hextensive">\n        <div class="plyr__controls controls left">\n        \t<img class="poster" data-plyr="cover" src="${t[0]?.poster||""}" alt="">\n        \t<div class="plyr_controls">\n            <div class="progressbar plyr__controls">\n                <div class="plyr__time plyr__time--current" aria-label="Current time">00:00</div>\n                <div class="plyr__progress">\n                    <input data-plyr="seek" type="range" min="0" max="100" step="0.01" value="0" aria-label="Seek">\n                    <progress class="plyr__progress__buffer" min="0" max="100" value="0">% buffered</progress>\n                    <span role="tooltip" class="plyr__tooltip">00:00</span>\n                </div>\n                <div class="plyr__time plyr__time--duration" aria-label="Duration">00:00</div>\n            </div>\n            <div class="main-controls plyr__controls">\n                <div class="repeat-shuffle" >\n                    <span class="plyr__control" data-plyr="shuffle"><svg class="icon">\n                    <use xlink:href="#shuffle"></use>\n                    </svg></span>\n                    <span class="plyr__control" active="false" data-plyr="repeat"><svg class="icon">\n                    <use xlink:href="#exchange"></use>\n                    </svg></span>\n                </div>\n                <div class="re-ply-fast">\n                    <button type="button" class="plyr__control" data-plyr="prev">\n                        <svg role="presentation"><use xlink:href="#plyr-rewind"></use></svg>\n                        <span class="plyr__tooltip" role="tooltip">Rewind {seektime} secs</span>\n                    </button>\n                    <button type="button" class="plyr__control" aria-label="Play, {title}" data-plyr="play">\n                        <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-pause"></use></svg>\n                        <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-play"></use></svg>\n                        <span class="label--pressed plyr__tooltip" role="tooltip">Pause</span>\n                        <span class="label--not-pressed plyr__tooltip" role="tooltip">Play</span>\n                    </button>\n                    <button type="button" class="plyr__control" data-plyr="next">\n                        <svg role="presentation"><use xlink:href="#plyr-fast-forward"></use></svg>\n                        <span class="plyr__tooltip" role="tooltip">Forward {seektime} secs</span>\n                    </button>\n                </div>\n                <div class="volume">\n                    <button type="button" class="plyr__control" aria-label="Mute" data-plyr="mute">\n                        <svg class="icon--pressed" role="presentation"><use xlink:href="#plyr-muted"></use></svg>\n                        <svg class="icon--not-pressed" role="presentation"><use xlink:href="#plyr-volume"></use></svg>\n                        <span class="label--pressed plyr__tooltip" role="tooltip">Unmute</span>\n                        <span class="label--not-pressed plyr__tooltip" role="tooltip">Mute</span>\n                    </button>\n                    <div class="plyr__volume">\n                        <input data-plyr="volume" type="range" min="0" max="1" step="0.05" value="1" autocomplete="off" aria-label="Volume">\n                    </div>\n                </div>\n            </div>\n          </div>\n            <div class="plyr__meta">\n                <h2 class="title" data-plyr="title">${t[0]?.title}</h2>\n                <h3 class="artist" data-plyr="artist">${t[0]?.artist}</h3>\n            </div>\n        </div>\n\t\t\t\t<div class="right">\n\t\t\t\t${t.map(((t,e)=>{let{title:n,artist:s}=t;return`<div class="hsong-item plyr__controlss"  data-index="${e}" data-audio-item>\n\t\t\t\t\t\t\t<span class="ply_icon">\n\t\t\t\t\t\t\t\t<button type="button" class="plyr__control" aria-label="Play, {title}">\n\t\t\t\t\t\t\t\t\t<svg class="icon--pressed" role="presentation">\n\t\t\t\t\t\t\t\t\t\t<use href="#plyr-pause"></use>\n\t\t\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t\t\t\t<svg class="icon--not-pressed" role="presentation">\n\t\t\t\t\t\t\t\t\t\t<use href="#plyr-play"></use>\n\t\t\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t\t\t</button>\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t<div class="meta-data">\n\t\t\t\t\t\t\t\t<h3 class="title">${n||""}</h3>\n\t\t\t\t\t\t\t\t<span class="singer">${s||""}</span>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<span class="time duration">00:00</span>\n\t\t\t\t\t\t</div>`})).join("")}\n\t\t\t\t</div>\n    \t</div>`};document.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll(".audioPlaylistCard").forEach((t=>{let e=[];try{e=JSON.parse(t.dataset?.items),t.removeAttribute("data-items")}catch(t){e=[]}o(t,{},e)})),document.querySelectorAll(".bluePlaylist:not(.elementorBluePlaylist)").forEach((t=>{let e=[];try{e=JSON.parse(t.dataset?.items),t.removeAttribute("data-items")}catch(t){e=[]}r(t,{},e)})),document.querySelectorAll(".simplePlaylist:not(.elementorSimplePlaylist)").forEach((t=>{let e=[],n={};try{e=JSON.parse(t.dataset?.items||"[]"),n=JSON.parse(t.dataset?.options||"{}"),t.removeAttribute("data-items"),t.removeAttribute("data-options")}catch(t){e=[]}console.log({playlist:t,options:n,items:e}),d(t,n,e)})),window.addEventListener("elementor/frontend/init",(function(){elementorFrontend.hooks.addAction("frontend/element_ready/PlaylistAudioPlayer.default",(function(t,e){const n=e(t).find(".elementorBluePlaylist")?.[0];if(n){let t=[];try{t=JSON.parse(n.dataset?.items),n.removeAttribute("data-items")}catch(e){t=[]}r(n,{},t)}const s=e(t).find(".elementorSimplePlaylist")?.[0];if(s){let t=[];try{t=JSON.parse(s.dataset?.items),s.removeAttribute("data-items")}catch(e){t=[]}d(s,{},t)}}))}))}));const r=function(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];return new a(t,{controls:l(n),...e},n)},o=function(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];const s=new a(t,{controls:i(n),...e},n);return t.getElementsByClassName("down-header")[0]?.addEventListener("click",(function(){t.querySelector("#list").style.height=parseInt(t.querySelector(".flat-black-player-container").offsetHeight)-135+"px",t.querySelector("#list-screen").classList.remove("slide-out-top"),t.querySelector("#list-screen").classList.add("slide-in-top"),t.querySelector("#list-screen").style.display="block"})),t.getElementsByClassName("hide-playlist")[0]?.addEventListener("click",(function(){t.querySelector("#list-screen").classList.remove("slide-in-top"),t.querySelector("#list-screen").classList.add("slide-out-top"),t.querySelector("#list-screen").style.display="none"})),s},d=function(t){return new a(t,{...arguments.length>1&&void 0!==arguments[1]?arguments[1]:{}},arguments.length>2&&void 0!==arguments[2]?arguments[2]:[])}})()})();
//# sourceMappingURL=playlist.js.map