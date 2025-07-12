  <form class="row" method="POST" action="{{ route('signaturepad.save_signiture') }}">
      @csrf
      <div class="col-md-12">
          <label class="form-label" for="card-email">Lokasi MCU</label>
          <input class="form-control form-control-lg text-center" type="text" value="{{ $data->mou_peserta_name }}"
              disabled />
      </div>
      <div class="col-md-6">
          <label class="form-label" for="card-email">Nama Pegawai</label>
          <input class="form-control form-control-lg text-center" type="text" value="{{ $data->mou_peserta_name }}"
              disabled />
      </div>
      <div class="col-md-6">
          <label class="form-label" for="card-email">Tanggal Lahir</label>
          <input class="form-control form-control-lg text-center" type="text" value="{{ $data->mou_peserta_ttl }}"
              disabled />

      </div>
      <div class="position-relative mt-2">
          <hr class="bg-300" />
          <div class="divider-content-center">Sign Here</div>
      </div>
      <div class="col-md-12">
          <a href="#" id="clear" class="text-danger float-end">Clear Signature</a>
          <canvas id="sig"></canvas>
      </div>
      <div class="col-12">
          <div class="form-check">
              <input class="form-check-input" type="checkbox" id="card-register-checkbox" required />
              <label class="form-label" for="card-register-checkbox">I
                  accept
                  the <a href="#!">terms </a>and <a href="#!">privacy
                      policy</a></label>
          </div>
      </div>
      <textarea id="signature64" name="signed" style="display: none" required></textarea>
      <input type="text" name="cabang" value="{{ $cabang->master_cabang_code }}" hidden>
      <input type="text" name="peserta" value="{{ $data->mou_peserta_code }}" hidden>
      <div class="col-md-12">
          <button class="btn btn-danger d-block w-100 " type="submit" name="submit">Register</button>
      </div>
  </form>
  <script type="text/javascript">
      var sig = $('#sig').signature({
          syncField: '#signature64',
          syncFormat: 'PNG'
      });
      sig.focus();
      $('#clear').click(function(e) {

          e.preventDefault();

          sig.signature('clear');

          $("#signature64").val('');

      });
  </script>
  <script>
      const mediaQuery = window.matchMedia('(max-width: 668px)');
      var canvas = document.querySelector("canvas");
      var ctx = canvas.getContext("2d");
      if (mediaQuery.matches) {
          var cw = (canvas.width = 300),
              cx = cw / 2;
          var ch = (canvas.height = 200),
              cy = ch / 2;
      } else {
          var cw = (canvas.width = 450),
              cx = cw / 2;
          var ch = (canvas.height = 200),
              cy = ch / 2;
      }
      ctx.strokeStyle = "#fff";
      var dibujando = false;
      var m = {
          x: 0,
          y: 0
      };

      var eventsRy = [{
              event: "mousedown",
              func: "onStart"
          },
          {
              event: "touchstart",
              func: "onStart"
          },
          {
              event: "mousemove",
              func: "onMove"
          },
          {
              event: "touchmove",
              func: "onMove"
          },
          {
              event: "mouseup",
              func: "onEnd"
          },
          {
              event: "touchend",
              func: "onEnd"
          },
          {
              event: "mouseout",
              func: "onEnd"
          }
      ];

      function onStart(evt) {
          m = oMousePos(canvas, evt);
          ctx.beginPath();
          dibujando = true;
      }

      function onMove(evt) {
          if (dibujando) {
              ctx.moveTo(m.x, m.y);
              m = oMousePos(canvas, evt);
              ctx.lineTo(m.x, m.y);
              ctx.stroke();
          }
      }

      function onEnd(evt) {
          dibujando = false;
      }

      function oMousePos(canvas, evt) {
          var ClientRect = canvas.getBoundingClientRect();
          var e = evt.touches ? evt.touches[0] : evt;

          return {
              x: Math.round(e.clientX - ClientRect.left),
              y: Math.round(e.clientY - ClientRect.top)
          };
      }

      for (var i = 0; i < eventsRy.length; i++) {
          (function(i) {
              var e = eventsRy[i].event;
              var f = eventsRy[i].func;
              console.log(f);
              canvas.addEventListener(e, function(evt) {
                  evt.preventDefault();
                  window[f](evt);
                  return;
              }, false);
          })(i);
      }

      clear.addEventListener(
          "click",
          function() {
              ctx.clearRect(0, 0, cw, ch);
          },
          false
      );
  </script>
