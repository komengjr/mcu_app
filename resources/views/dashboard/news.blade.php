@extends('layouts.home')
@section('content')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header bg-light overflow-hidden">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-m">
                            <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />

                        </div>
                        <div class="flex-1 ms-2">
                            <h5 class="mb-0 fs-0">Create post</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form>
                        <textarea class="shadow-none form-control rounded-0 resize-none px-card border-y-0 border-200"
                            placeholder="What do you want to talk about?" rows="4"></textarea>
                        <div class="d-flex align-items-center ps-card border border-200">
                            <label class="text-nowrap mb-0 me-2" for="hash-tags"><span
                                    class="fas fa-plus me-1 fs--2"></span><span class="fw-medium fs--1">Add
                                    hashtag</span></label>
                            <input class="form-control border-0 fs--1 shadow-none" id="hash-tags" type="text"
                                placeholder="Help the right person to see" />
                        </div>
                        <div class="row g-0 justify-content-between mt-3 px-card pb-3">
                            <div class="col">
                                <button
                                    class="btn btn-light btn-sm rounded-pill shadow-none d-inline-flex align-items-center fs--1 mb-0 me-1"
                                    type="button"><img class="cursor-pointer"
                                        src="../../assets/img/icons/spot-illustrations/image.svg" width="17"
                                        alt="" /><span class="ms-2 d-none d-md-inline-block">Image</span></button>
                                <button
                                    class="btn btn-light btn-sm rounded-pill shadow-none d-inline-flex align-items-center fs--1 me-1"
                                    type="button"><img class="cursor-pointer"
                                        src="../../assets/img/icons/spot-illustrations/calendar.svg" width="17"
                                        alt="" /><span class="ms-2 d-none d-md-inline-block">Event</span></button>
                                <button
                                    class="btn btn-light btn-sm rounded-pill shadow-none d-inline-flex align-items-center fs--1 me-1"
                                    type="button"><img class="cursor-pointer"
                                        src="../../assets/img/icons/spot-illustrations/location.svg" width="17"
                                        alt="" /><span class="ms-2 d-none d-md-inline-block text-nowrap">Check
                                        in</span></button>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block me-1">
                                    <button class="btn btn-sm dropdown-toggle px-1" id="dropdownMenuButton" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-globe-americas"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a
                                            class="dropdown-item" href="#">Public</a><a class="dropdown-item"
                                            href="#">Private</a><a class="dropdown-item" href="#">Draft</a>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm px-4 px-sm-5" type="submit">Share</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="d-flex">
                                <div class="avatar avatar-2xl status-online">
                                    <img class="rounded-circle" src="../../assets/img/team/4.jpg" alt="" />

                                </div>
                                <div class="flex-1 align-self-center ms-2">
                                    <p class="mb-1 lh-1"><a class="fw-semi-bold" href="../../pages/user/profile.html">Rowan
                                            Atkinson</a> shared an <a href="#!">album</a></p>
                                    <p class="mb-0 fs--1">11 hrs &bull; Consett, UK &bull; <span
                                            class="fas fa-globe-americas"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown font-sans-serif">
                                <button class="btn btn-sm dropdown-toggle p-1 dropdown-caret-none" type="button"
                                    id="post-album-action" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-3" aria-labelledby="post-album-action"><a
                                        class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                        href="#!">Edit</a><a class="dropdown-item" href="#!">Report</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning"
                                        href="#!">Archive</a><a class="dropdown-item text-danger"
                                        href="#!">Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body overflow-hidden">
                    <p>Rowan Sebastian Atkinson CBE is an English actor, comedian and screenwriter best known for his work
                        on the sitcoms Blackadder and Mr. Bean.</p>
                    <div class="row mx-n1">
                        <div class="col-6 p-1"><a href="../../assets/img/generic/4.jpg" data-gallery="gallery-1"><img
                                    class="img-fluid rounded" src="../../assets/img/generic/4.jpg" alt="" /></a>
                        </div>
                        <div class="col-6 p-1"><a href="../../assets/img/generic/5.jpg" data-gallery="gallery-1"><img
                                    class="img-fluid rounded" src="../../assets/img/generic/5.jpg" alt="" /></a>
                        </div>
                        <div class="col-4 p-1"><a href="../../assets/img/gallery/4.jpg" data-gallery="gallery-1"><img
                                    class="img-fluid rounded" src="../../assets/img/gallery/4.jpg" alt="" /></a>
                        </div>
                        <div class="col-4 p-1"><a href="../../assets/img/gallery/5.jpg" data-gallery="gallery-1"><img
                                    class="img-fluid rounded" src="../../assets/img/gallery/5.jpg" alt="" /></a>
                        </div>
                        <div class="col-4 p-1"><a href="../../assets/img/gallery/3.jpg" data-gallery="gallery-1"><img
                                    class="img-fluid rounded" src="../../assets/img/gallery/3.jpg" alt="" /></a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light pt-0">
                    <div class="border-bottom border-200 fs--1 py-3"><a class="text-700" href="#!">345 Likes</a>
                        &bull; <a class="text-700" href="#!">34 Comments</a>
                    </div>
                    <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/like-active.png" width="20"
                                    alt="" /><span class="ms-1">Like</span></a></div>
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/comment-active.png" width="20"
                                    alt="" /><span class="ms-1">Comment</span></a></div>
                        <div class="col-auto d-flex align-items-center"><a
                                class="rounded-2 text-700 d-flex align-items-center" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/share-inactive.png" width="20"
                                    alt="" /><span class="ms-1">Share</span></a></div>
                    </div>
                    <form class="d-flex align-items-center border-top border-200 pt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <input class="form-control rounded-pill ms-2 fs--1" type="text"
                            placeholder="Write a comment..." />
                    </form>
                    <div class="d-flex mt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/4.jpg" alt="" />

                        </div>
                        <div class="flex-1 ms-2 fs--1">
                            <p class="mb-1 bg-200 rounded-3 p-2"><a class="fw-semi-bold"
                                    href="../../pages/user/profile.html">Rowan Atkinson</a> She starred as Jane Porter in
                                The <a href="#!">@Legend of Tarzan (2016)</a>, Tanya Vanderpoel in Whiskey Tango
                                Foxtrot (2016) and as DC comics villain Harley Quinn in Suicide Squad (2016), for which she
                                was nominated for a Teen Choice Award, and many other awards.</p>
                            <div class="px-2"><a href="#!">Like</a> &bull; <a href="#!">Reply</a> &bull;
                                23min </div>
                        </div>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <div class="flex-1 ms-2 fs--1">
                            <p class="mb-1 bg-200 rounded-3 p-2"><a class="fw-semi-bold"
                                    href="../../pages/user/profile.html">Jessalyn Gilsig</a> Jessalyn Sarah Gilsig is a
                                Canadian-American actress known for her roles in television series, e.g., as Lauren Davis in
                                Boston Public, Gina Russo in Nip/Tuck, Terri Schuester in Glee, and as Siggy Haraldson on
                                the History Channel series Vikings. 🏆</p>
                            <div class="px-2"><a href="#!">Like</a> &bull; <a href="#!">Reply</a> &bull; 3hrs
                            </div>
                        </div>
                    </div><a class="fs--1 text-700 d-inline-block mt-2" href="#!">Load more comments (2 of 34)</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="d-flex">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="../../assets/img/team/15.jpg" alt="" />

                                </div>
                                <div class="flex-1 align-self-center ms-2">
                                    <p class="mb-1 lh-1"><a class="fw-semi-bold"
                                            href="../../pages/user/profile.html">Margot Robbie</a></p>
                                    <p class="mb-0 fs--1">Yesterday &bull; Dalby &bull; <span class="fas fa-users"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown font-sans-serif">
                                <button class="btn btn-sm dropdown-toggle p-1 dropdown-caret-none" type="button"
                                    id="post-article-action" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-3" aria-labelledby="post-article-action"><a
                                        class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                        href="#!">Edit</a><a class="dropdown-item" href="#!">Report</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning"
                                        href="#!">Archive</a><a class="dropdown-item text-danger"
                                        href="#!">Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Margot Elise Robbie was born on July 2, 1990 in Dalby, Queensland, Australia to Scottish parents. Her
                        mother, Sarie Kessler, is a physiotherapist, and her father, is Doug Robbie. She comes from a family
                        of four children, having two brothers and one sister. She graduated from Somerset College in
                        Mudgeeraba, Queensland, Australia, a suburb in the Gold Coast hinterland of South East Queensland,
                        where she and her siblings were raised by their mother and spent much of her time at the farm
                        belonging to her grandparents. In her late teens, she moved to Melbourne, Victoria, Australia to
                        pursue an acting career.</p>
                    <p>From 2008-2010, Robbie played the character of Donna Freedman in the long-running Australian soap
                        opera, Neighbours (1985), for which she was nominated for two Logie Awards. She set off to pursue
                        Hollywood opportunities, quickly landing the role of Laura Cameron on the short-lived ABC series,
                        Pan Am (2011). She made her big screen debut in the film, About Time (2013).</p>
                    <p>Robbie rose to fame co-starring alongside Leonardo DiCaprio, portraying the role of Naomi Lapaglia in
                        Martin Scorsese's Oscar-nominated film, The Wolf of Wall Street (2013). She was nominated for a
                        Breakthrough Performance MTV Movie Award, and numerous other awards.</p>
                    <p>In 2014, Robbie founded her own production company, LuckyChap Entertainment. She also appeared in the
                        World War II romantic-drama film, Suite Française (2014). She starred in Focus (2015) and Z for
                        Zachariah (2015), and made a cameo in The Big Short (2015).</p>
                    <p>In 2016, she married Tom Ackerley in Byron Bay, New South Wales, Australia.</p>
                    <p>She starred as Jane Porter in The Legend of Tarzan (2016), Tanya Vanderpoel in Whiskey Tango Foxtrot
                        (2016) and as DC comics villain Harley Quinn in Suicide Squad (2016), for which she was nominated
                        for a Teen Choice Award, and many other awards.</p>
                    <p>She portrayed figure skater Tonya Harding in the biographical film I, Tonya (2017), receiving
                        critical acclaim and a Golden Globe Award nomination for Best Actress - Motion Picture Comedy or
                        Musical.</p>
                </div>
                <div class="card-footer bg-light pt-0">
                    <div class="border-bottom border-200 fs--1 py-3"><a class="text-700" href="#!">34 Comments</a>
                    </div>
                    <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/like-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Like</span></a></div>
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/comment-active.png" width="20"
                                    alt="" /><span class="ms-1">Comment</span></a></div>
                        <div class="col-auto d-flex align-items-center"><a
                                class="rounded-2 text-700 d-flex align-items-center" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/share-inactive.png" width="20"
                                    alt="" /><span class="ms-1">Share</span></a></div>
                    </div>
                    <form class="d-flex align-items-center border-top border-200 pt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <input class="form-control rounded-pill ms-2 fs--1" type="text"
                            placeholder="Write a comment..." />
                    </form>
                    <div class="d-flex mt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/4.jpg" alt="" />

                        </div>
                        <div class="flex-1 ms-2 fs--1">
                            <p class="mb-1 bg-200 rounded-3 p-2"><a class="fw-semi-bold"
                                    href="../../pages/user/profile.html">Rowan Atkinson</a> She starred as Jane Porter in
                                The <a href="#!">@Legend of Tarzan (2016)</a>, Tanya Vanderpoel in Whiskey Tango
                                Foxtrot (2016) and as DC comics villain Harley Quinn in Suicide Squad (2016), for which she
                                was nominated for a Teen Choice Award, and many other awards.</p>
                            <div class="px-2"><a href="#!">Like</a> &bull; <a href="#!">Reply</a> &bull;
                                23min </div>
                        </div>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <div class="flex-1 ms-2 fs--1">
                            <p class="mb-1 bg-200 rounded-3 p-2"><a class="fw-semi-bold"
                                    href="../../pages/user/profile.html">Jessalyn Gilsig</a> Jessalyn Sarah Gilsig is a
                                Canadian-American actress known for her roles in television series, e.g., as Lauren Davis in
                                Boston Public, Gina Russo in Nip/Tuck, Terri Schuester in Glee, and as Siggy Haraldson on
                                the History Channel series Vikings. 🏆</p>
                            <div class="px-2"><a href="#!">Like</a> &bull; <a href="#!">Reply</a> &bull; 3hrs
                            </div>
                        </div>
                    </div><a class="fs--1 text-700 d-inline-block mt-2" href="#!">Load more comments (2 of 34)</a>
                </div>
            </div>
            <div class="card mb-3"><img class="card-img-top" src="../../assets/img/generic/13.jpg" alt="" />
                <div class="card-body overflow-hidden">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <div class="d-flex">
                                <div class="calendar me-2"><span class="calendar-month">Dec</span><span
                                        class="calendar-day">31 </span></div>
                                <div class="flex-1 fs--1">
                                    <h5 class="fs-0"><a href="../../app/events/event-detail.html">FREE New Year's Eve
                                            Midnight Harbor Fireworks</a></h5>
                                    <p class="mb-0">by <a href="#!">Boston Harbor Now</a></p><span
                                        class="fs-0 text-warning fw-semi-bold">$49.99 – $89.99</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto d-none d-md-block">
                            <button class="btn btn-falcon-default btn-sm px-4" type="button">Register</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light pt-0">
                    <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/like-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Like</span></a></div>
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/comment-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Comment</span></a></div>
                        <div class="col-auto d-flex align-items-center"><a
                                class="rounded-2 text-700 d-flex align-items-center" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/share-inactive.png" width="20"
                                    alt="" /><span class="ms-1">Share</span></a></div>
                    </div>
                    <form class="d-flex align-items-center border-top border-200 pt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <input class="form-control rounded-pill ms-2 fs--1" type="text"
                            placeholder="Write a comment..." />
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="d-flex">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="../../assets/img/team/10.jpg" alt="" />

                                </div>
                                <div class="flex-1 align-self-center ms-2">
                                    <p class="mb-1 lh-1"><a class="fw-semi-bold"
                                            href="../../pages/user/profile.html">Leonardo DiCaprio</a> shared a <a
                                            href="#!">photo</a></p>
                                    <p class="mb-0 fs--1">13 Jan &bull; LA, US &bull; <span
                                            class="fas fa-globe-americas"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown font-sans-serif">
                                <button class="btn btn-sm dropdown-toggle p-1 dropdown-caret-none" type="button"
                                    id="post-image-action" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-3" aria-labelledby="post-image-action"><a
                                        class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                        href="#!">Edit</a><a class="dropdown-item" href="#!">Report</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning"
                                        href="#!">Archive</a><a class="dropdown-item text-danger"
                                        href="#!">Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body overflow-hidden"><a href="../../assets/img/generic/11.jpg"
                        data-gallery="gallery-2"><img class="img-fluid rounded" src="../../assets/img/generic/11.jpg"
                            alt="" /></a></div>
                <div class="card-footer bg-light pt-0">
                    <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/like-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Like</span></a></div>
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/comment-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Comment</span></a></div>
                        <div class="col-auto d-flex align-items-center"><a
                                class="rounded-2 text-700 d-flex align-items-center" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/share-inactive.png" width="20"
                                    alt="" /><span class="ms-1">Share</span></a></div>
                    </div>
                    <form class="d-flex align-items-center border-top border-200 pt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <input class="form-control rounded-pill ms-2 fs--1" type="text"
                            placeholder="Write a comment..." />
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="d-flex">
                                <div class="avatar avatar-2xl">
                                    <img class="rounded-circle" src="../../assets/img/team/8.jpg" alt="" />

                                </div>
                                <div class="flex-1 align-self-center ms-2">
                                    <p class="mb-1 lh-1"><a class="fw-semi-bold"
                                            href="../../pages/user/profile.html">Johnny Depp</a> shared a <a
                                            href="#!">video</a></p>
                                    <p class="mb-0 fs--1">Just Now &bull; Paris &bull; <span class="fas fa-users"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown font-sans-serif">
                                <button class="btn btn-sm dropdown-toggle p-1 dropdown-caret-none" type="button"
                                    id="post-video-action" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-3" aria-labelledby="post-video-action"><a
                                        class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                        href="#!">Edit</a><a class="dropdown-item" href="#!">Report</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning"
                                        href="#!">Archive</a><a class="dropdown-item text-danger"
                                        href="#!">Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>See the sport of surfing as it’s never been captured before in John Florence and Blake Vincent
                        Kueny’s second signature release, in association with the award-winning film studio, Brain Farm. The
                        first surf film shot entirely in 4K, View From a Blue Moon. 🤩 🌎 🎬</p>
                    <div>
                        <div class="player" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div>
                    </div>
                </div>
                <div class="card-footer bg-light pt-0">
                    <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/like-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Like</span></a></div>
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/comment-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Comment</span></a></div>
                        <div class="col-auto d-flex align-items-center"><a
                                class="rounded-2 text-700 d-flex align-items-center" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/share-inactive.png" width="20"
                                    alt="" /><span class="ms-1">Share</span></a></div>
                    </div>
                    <form class="d-flex align-items-center border-top border-200 pt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <input class="form-control rounded-pill ms-2 fs--1" type="text"
                            placeholder="Write a comment..." />
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="d-flex">
                                <div class="avatar avatar-2xl status-online">
                                    <img class="rounded-circle" src="../../assets/img/team/17.jpg" alt="" />

                                </div>
                                <div class="flex-1 align-self-center ms-2">
                                    <p class="mb-1 lh-1"><a class="fw-semi-bold"
                                            href="../../pages/user/profile.html">Emilia Clarke</a> shared a <a
                                            href="#!">url</a></p>
                                    <p class="mb-0 fs--1">14 Feb &bull; London &bull; <span
                                            class="fas fa-globe-americas"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown font-sans-serif">
                                <button class="btn btn-sm dropdown-toggle p-1 dropdown-caret-none" type="button"
                                    id="post-url-action" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-3" aria-labelledby="post-url-action"><a
                                        class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                        href="#!">Edit</a><a class="dropdown-item" href="#!">Report</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning"
                                        href="#!">Archive</a><a class="dropdown-item text-danger"
                                        href="#!">Delete </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body overflow-hidden">
                    <p>Mount Everest, known in Nepali as Sagarmatha and in Tibetan as Chomolungma, is Earth's highest
                        mountain above sea level, located in the Mahalangur Himal sub-range of the Himalayas. The
                        international border between Nepal and China runs across its summit point.</p><a
                        class="text-decoration-none" href="#!"><img class="img-fluid rounded"
                            src="../../assets/img/generic/12.jpg" alt="" /><small
                            class="text-uppercase text-700">en.wikipedia.org</small>
                        <h6 class="fs-0 mb-0">Mount Everest: Facts & Location of World's Highest Mountain</h6>
                        <p class="fs--1 mb-0 text-700">The Himalayan range has many of the Earth's highest peaks, including
                            the highest, Mount Everest...</p>
                    </a>
                </div>
                <div class="card-footer bg-light pt-0">
                    <div class="border-bottom border-200 fs--1 py-3"><a class="text-700" href="#!">345 Likes</a>
                    </div>
                    <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/like-active.png" width="20"
                                    alt="" /><span class="ms-1">Like</span></a></div>
                        <div class="col-auto"><a class="rounded-2 d-flex align-items-center me-3 text-700"
                                href="#!"><img src="../../assets/img/icons/spot-illustrations/comment-inactive.png"
                                    width="20" alt="" /><span class="ms-1">Comment</span></a></div>
                        <div class="col-auto d-flex align-items-center"><a
                                class="rounded-2 text-700 d-flex align-items-center" href="#!"><img
                                    src="../../assets/img/icons/spot-illustrations/share-inactive.png" width="20"
                                    alt="" /><span class="ms-1">Share</span></a></div>
                    </div>
                    <form class="d-flex align-items-center border-top border-200 pt-3">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                        </div>
                        <input class="form-control rounded-pill ms-2 fs--1" type="text"
                            placeholder="Write a comment..." />
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="sticky-sidebar">
                <div class="card mb-3">
                    <div class="card-body fs--1">
                        <div class="d-flex"><span class="fas fa-gift fs-0 text-warning"></span>
                            <div class="flex-1 ms-2"><a class="fw-semi-bold" href="../../pages/user/profile.html">Emma
                                    Watson</a>'s Birthday is today</div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add to your feed</h5><a class="fs--1" href="#!">See all</a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/13.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Katheryn Winnick</a></h6>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/5.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Travis Fimmel</a></h6>
                                <p class="fs--1 mb-0">5 mutual connections</p>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/10.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Gustaf Skarsgård</a></h6>
                                <p class="fs--1 mb-0">10 mutual connections</p>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/8.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Clive Standen</a></h6>
                                <p class="fs--1 mb-0">8 mutual connections</p>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/15.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Jennie Jacques</a></h6>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/6.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Isaac Hempstead</a></h6>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/2.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Antony Hopkins</a></h6>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="avatar avatar-3xl">
                                <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt="" />

                            </div>
                            <div class="flex-1 ms-2">
                                <h6 class="mb-0"><a href="../../pages/user/profile.html">Sophie Turner</a></h6>
                                <button class="btn btn-light btn-sm py-0 mt-1 border" type="button"><span
                                        class="fas fa-user-plus" data-fa-transform="shrink-5 left-2"></span><span
                                        class="fs--1">Follow</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 mb-lg-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">You may interested</h5>
                    </div>
                    <div class="card-body fs--1">
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><span class="calendar-month">Feb</span><span
                                    class="calendar-day">21</span>
                            </div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">Newmarket Nights</a>
                                </h6>
                                <p class="mb-1">Organized by <a href="#!" class="text-700">University of
                                        Oxford</a>
                                </p>
                                <p class="text-1000 mb-0">Time: 6:00AM</p>
                                <p class="text-1000 mb-0">Duration: 6:00AM - 5:00PM</p>Place: Cambridge Boat Club,
                                Cambridge
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><span class="calendar-month">Dec</span><span
                                    class="calendar-day">31</span>
                            </div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">31st Night
                                        Celebration</a>
                                </h6>
                                <p class="mb-1">Organized by <a href="#!" class="text-700">Chamber Music
                                        Society</a>
                                </p>
                                <p class="text-1000 mb-0">Time: 11:00PM</p>
                                <p class="text-1000 mb-0">280 people interested</p>Place: Tavern on the Greend, New York
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        <div class="d-flex btn-reveal-trigger">
                            <div class="calendar"><span class="calendar-month">Dec</span><span
                                    class="calendar-day">16</span>
                            </div>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0"><a href="../../app/events/event-detail.html">Folk Festival</a></h6>
                                <p class="mb-1">Organized by <a href="#!" class="text-700">Harvard University</a>
                                </p>
                                <p class="text-1000 mb-0">Time: 9:00AM</p>
                                <p class="text-1000 mb-0">Location: Cambridge Masonic Hall Association</p>Place: Porter
                                Square,
                                North Cambridge
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-0 border-top"><a class="btn btn-link d-block w-100"
                            href="../../app/events/event-list.html">All Events<span
                                class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
