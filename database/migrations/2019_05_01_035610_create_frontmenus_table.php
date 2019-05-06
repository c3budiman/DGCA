<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontmenu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('method');
            $table->text('content');
            $table->timestamps();
        });

        $this->generatePage('home');
        $this->generatePage('pendaftaran');

        //insert content :
        DB::table('frontmenu')->insert([
            [
             'nama' => 'Beranda',
             'method' => 'home' ,
             'content' => "
              <style>
                  .span8 img {
                      margin-right: 80px;
                  }
                  .span8 .img-left {
                      float: left;
                  }
                  .span8 .img-right {
                      float: right;
                  }
                  #call-to-action {
                      padding: 80px;
                      padding-right: 110px;
                  }
                  </style>

                  <section id='team'>
                    <div class='container'>
                      <div class='section-header wow fadeInUp' style='visibility: visible; animation-name: fadeInUp;'>
                        <h3>Pendaftaran Online</h3>
                        <p>Silahkan melakukan pendaftaran anggota, drone dan zona terbang anda untuk kenyamanan dan keamanan.</p>
                      </div>

                      <div class='row'>

                        <div class='col-lg-6 col-md-6 wow fadeInUp' style='visibility: visible; animation-name: fadeInUp;'>
                          <div class='member'>
                            <img src='gambar/drone2.jpg' class='img-fluid' alt=''>
                          </div>
                        </div>

                        <div class='col-lg-6 col-md-6 wow fadeInUp' data-wow-delay='0.1s' style='visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;'>
                          <div class='member'>
                            <img src='gambar/drone3.jpg' class='img-fluid' alt=''>
                          </div>
                        </div>

                        <br>

                          <div class='span8'>
                          <img class='img-left' src='gambar/drone1.jpg'>
                          <section id='call-to-action' class='wow fadeIn' style='visibility: visible; animation-name: fadeIn;'>
                            <div class='content-heading'><h3>REKOMANDASI IZIN TERBANG &nbsp; </h3></div>
                            <p>Silahkan mengajukan izin zona terbang untuk mendapatkan rekomendasi izin terbang pada area yang aman.</p>

                            <div class='content-heading'><h3>Pendaftaran Sistem Pesawat Udara Kecil Tanpa Awak (Drone) &nbsp; </h3></div>
                            <p>Silahkan melakukan pendaftaran Drone pada menu pendaftaran untuk mendapatkan Sertifikat Drone anda.</p>
                            <a class='cta-btn' href='/pendaftaran'>Daftar</a>
                           </section>


                          </div>


                      </div>


                    </div>
                  </section>

                  <section id='about'>
                    <div class='container'>

                      <header class='section-header'>
                        <h3>Pelayanan</h3>
                        <p>Kami Memberikan pelayanan dalam pengawasan, peregistrasian drone, dan lisensi pilot.</p>
                      </header>

                      <div class='row about-cols'>

                        <div class='col-md-6 wow fadeInUp' style='visibility: visible; animation-name: fadeInUp;'>
                          <div class='about-col'>
                            <div class='img'>
                              <img src='assets/img/about-plan.jpg' alt='' class='img-fluid'>
                              <div class='icon'><i class='ion-ios-speedometer-outline'></i></div>
                            </div>
                            <h2 class='title'><a href='#'>REGISTRASI DRONE</a></h2>
                            <p>
                              Semua drone dengan berat 250 gram keatas sampai dengan 25 kg wajib didaftarkan di DKPPU sesuai CASR 107 Subpart C.
                            </p>
                            <p>
                                Drone juga dapat didaftarkan sesuai dengan ketentuan CASR 47.
                            </p>
                          </div>
                        </div>

                        <div class='col-md-6 wow fadeInUp' data-wow-delay='0.2s' style='visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;'>
                          <div class='about-col'>
                            <div class='img'>
                              <img src='assets/img/about-vision.jpg' alt='' class='img-fluid'>
                              <div class='icon'><i class='ion-ios-eye-outline'></i></div>
                            </div>
                            <h2 class='title'><a href='#'>Respon Cepat</a></h2>
                            <p>
                              Semua pengajuan dan pendaftaran akan diproses dengan cepat dan transparan.
                            </p>
                            <br>
                            <br>
                          </div>
                        </div>

                      </div>

                    </div>
                </section>
             "
           ],
           [
            'nama' => 'Pendaftaran',
            'method' => 'pendaftaran' ,
            'content' => "
                    <section id='facts' class='wow fadeIn' style='visibility: visible; animation-name: fadeIn; margin-top:-60px; margin-bottom:-60px;'>
                          <div class='container'>

                            <header class='section-header'>
                              <h3>Pendaftaran</h3>
                              <p>Semua drone dengan berat 250 gram keatas sampai dengan 25 kg wajib didaftarkan di DKPPU sesuai CASR 107 Subpart C.
                              Silahkan pilih tipe pelayanan :
                              </p>
                            </header>

                            <div class='row counters'>

                      		 <div class='col-lg-6 col-6 text-center'>
                                <a class='btn btn-info' href='/daftar?reg=bisnis'> <i class='fa fa-suitcase'> </i> Pendaftaran untuk Bisnis/Komersial </a>
                      		 </div>

                              <div class='col-lg-6 col-6 text-center'>
                                <a class='btn btn-primary' href='/daftar?reg=hobby'> <i class='fa fa-child'> </i> Pendaftaran untuk Rekreasi/Hobby</a>
                      		  </div>

                      		</div>

                      		<br>
                      		<br>
                      		<br>

                      		<div class='row counters'>

                      		 <div class='col-lg-12 col-12 text-center'>
                      		     Sudah Memiliki Akun?
                                <a href='/login'> klik disini untuk Login </a>
                      		 </div>

                      		</div>

                            <div class='facts-img'>
                              <img src='img/facts-img.png' alt='' class='img-fluid'>
                            </div>

                          </div>
                    </section>
            "
          ],
        ]);
    }

    public function generatePage($param) {
      try {
        //create new tabel for submenu :
        Schema::create(strtolower($param), function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('parent')->nullable();
            $table->string('nama');
            $table->string('method');
            $table->text('content');
            $table->timestamps();
        });

        //generate code for crud backend, view for frontend
        $exitCode = Artisan::call('crud:generator', ['name' => strtolower($param)]);
      } catch (\Exception $e) {

      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('frontmenu');
    }
}
